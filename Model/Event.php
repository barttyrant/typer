<?php
App::uses('AppModel', 'Model');
App::uses('simple_html_dom', 'Vendor');
/**
 * Event Model
 *
 * @property Bet $Bet
 * @property Odd $Odd
 */
class Event extends AppModel {

	public $displayField = 'title';
	public $hasMany = array('Bet', 'Odd');
    
    const CLOSE_EVENT_BEFORE_START = 1800;
    
    public $sources = array(
        array(
            'label' => 'FULL_TIME_OUTCOME',
            'url' => 'https://pl.betclic.com/sport/eventdetail.aspx?id=122&t=Ftb_Mr3',
        ),
        array(
            'label' => 'FULL_TIME_OUTCOME_DC',
            'url' => 'https://pl.betclic.com/sport/eventdetail.aspx?id=122&t=Ftb_Dbc',
        ),       
    );
    
    
    public function saveFetchedInfo($events){
        if(empty($events)){
            return false;
        }
        $evSaved = $odSaved = $odUpdat = 0;
        
        
        foreach($events as $eventType => $evs){
            
            foreach ($evs as $ev) {
                $oddsNames = !empty($ev['labels']['odds']) ? $ev['labels']['odds'] : false;
                $dateStr = !empty($ev['labels']['dateStr']) ? $ev['labels']['dateStr'] : false;

                if ($oddsNames && $dateStr) {
                    $dateStr = trim(substr($dateStr, stripos($dateStr, ' ')));
                    $dateStr = trim(substr($dateStr, 0, stripos($dateStr, ' ')));
                    

                    $date = '2012-06-' . $dateStr;

                    if (!empty($ev['events'])) {
                        foreach ($ev['events'] as $evt) {
                            $odds = array();
                            $eventName = !empty($evt[1]) ? $evt[1] : false;
                            $time = !empty($evt[0]) ? $evt[0] : false;
                            for ($i = 1; $i <= count($oddsNames); $i++) {
                                $odds[] = array(
                                    'name' => $oddsNames[$i-1],
                                    'value' => str_replace(',', '.', $evt[$i+1])
                                );
                            }
                            
                            $dateDay = $date;
                            $dateFull = $dateDay . ' ' . $time . ':00';  
                            
                            $startDate = date('Y-m-d H:i:s', strtotime($dateFull));
                            
                            $eventData = array(
                                'title' => $eventName,
                                'start_date' => $startDate,
                                'hash' => md5($eventName . ' - ' . $date),
                                'description' => false,
                            );
                            
                            $this->contain = false;
                            $eventRecord = $this->findByHash($eventData['hash']);
                            
                            if(empty($eventRecord)){
                                $this->create();
                                if($this->save(array('Event' => $eventData))){
                                    $evSaved++;                                    
                                }              
                                $evtId = $this->getLastInsertID();
                            }
                            else{
                                $evtId = $eventRecord['Event']['id'];
                            }
                            foreach ($odds as $oddData) {
                                $oddData['event_id'] = $evtId;
                                $oddData['hash'] = md5($evtId . ' - ' . $oddData['name']);
                                $this->Odd->contain = false;
                                $oddRecord = $this->Odd->findByHash($oddData['hash']);

                                if (empty($oddRecord)) {
                                    $this->Odd->create();
                                    if ($this->Odd->save(array('Odd' => $oddData))) {
                                        $odSaved++;
                                    }
                                } else {
                                    if ((float) $oddData['value'] != $oddRecord['Odd']['value']) {
                                        if ($this->Odd->updateAll(array(
                                                'Odd.value' => (float) $oddData['value']
                                                ), array('Odd.id' => $oddRecord['Odd']['id']))) {
                                            $odUpdat++;
                                            $this->log('Updated odd ' . $oddRecord['Odd']['id'].  ' from ' . $oddRecord['Odd']['value'] . ' to ' . $oddData['value'], 'odds_update');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return(array(
            'evSaved' => $evSaved,
            'odSaved' => $odSaved,
            'odUpdat' => $odUpdat
        ));
    }
    
    
    
    public function fetchEventsInfo($sources = null){        
        
        if(is_null($sources)){
            $sources = $this->sources;
        }
        
        $return = array();
        
        foreach ($sources as $src) {
            $url = $src['url'];
            $label = $src['label'];

            $ch = curl_init();
            $timeout = 30;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            
            $fileName = md5($url . date('Y-m-d H'));
            $fullFileName = APP . 'tmp' . DS . 'feeds' . DS . $fileName;
            
            if(!file_exists($fullFileName)){
                $data = curl_exec($ch);
                file_put_contents($fullFileName, $data);
            }
            else{
                $data = file_get_contents($fullFileName);
            }
            
            curl_close($ch);
            $events = array();
            
            if (!empty($data)) {

                $data = substr($data, stripos($data, '<!-- Fin bet live -->') + strlen('<!-- Fin bet live -->'));
                $data = trim(substr($data, 0, stripos($data, '<!-- Fin Tableau -->')));               

                $html = new simple_html_dom();

                // Load from a string  
                $html->load("<html><body>$data</body></html>");

                $tables = $html->find('table table');

                foreach ($tables as $table) {
                    $attrs = $table->attr;

                    if (!is_array($attrs) || empty($attrs['id'])) {
                        continue;
                    }

                    $id = trim($attrs['id']);

                    if (preg_match('/^(ctl00_cpMain_repTypeAndContent_ctl[0-9]+_ctl){1}.+(_TitleBox_tbl){1}$/', $id, $m)) {
                        // event header
                        $index = str_replace(array($m[1], $m[2]), array('', ''), $m[0]);

                        $headerTableTds = $html->find('#' . $id . ' table tr td');
                        $dateStr = $headerTableTds[0];
                        $dateStr = trim(strip_tags($dateStr->text()));
                        $oddLabels = array();

                        for ($i = 1; $i < count($headerTableTds); $i++) {
                            $node = $headerTableTds[$i];
                            $nodeText = trim(strip_tags($node->text()));
                            if (!empty($nodeText)) {
                                $oddLabels[] = $nodeText;
                            }
                        }

                        $events[$index]['labels'] = array(
                            'dateStr' => $dateStr,
                            'odds' => $oddLabels
                        );
                    } elseif (preg_match('/^(ctl00_cpMain_repTypeAndContent_ctl[0-9]+_ctl){1}.+(_ContentBox_tbl){1}$/', $id, $m)) {
                        // event odds table
                        $index = str_replace(array($m[1], $m[2]), array('', ''), $m[0]);

                        $eventRows = $html->find('#' . $id . ' table tr.evtRow');
                        
                        $timeStart = null;
                        for ($i = 0; $i < count($eventRows); $i++) {
                            $rowNode = $eventRows[$i];
                            $tds = $rowNode->find('td');
                            foreach ($tds as $k => $td) {
                                $tdText = trim(strip_tags(str_replace('&nbsp;', '', ($td->text()))));
                                if (!empty($tdText)) {
                                    if(preg_match('/^[0-9]{2}:[0-9]{2}$/', $tdText)){
                                        $timeStart = $tdText;                                        
                                    }
                                    else{
                                        $events[$index]['events'][$i][] = $tdText;
                                    }
                                }
                            }
                            $events[$index]['events'][$i][-1] = $timeStart;
                            ksort($events[$index]['events'][$i]);
                            $events[$index]['events'][$i] = array_values($events[$index]['events'][$i]);
                        }
                    }
                }
            }
            
            $return[$label] = array_values($events);
        }
        
        return $return;
    }

}
