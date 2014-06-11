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

    public function saveFetchedInfo($events) {

        foreach($events as $event){

            $eventRecord = $this->findByHash($event['Event']['hash']);

            if(empty($eventRecord)){
                $this->create();
                $saved = $this->save(array('Event' => $event['Event']));

                if($saved){
                    $this->log('INF: Saved new event ' . json_encode($event['Event']), 'odder');
                }
                else{
                    $this->log('ERR: Unable to save new event ' . json_encode($event['Event']), 'odder');
                }
            }

            

        }

//        return(array(
//            'evSaved' => $evSaved,
//            'odSaved' => $odSaved,
//            'odUpdat' => $odUpdat
//        ));
    }

    public function fetchEventsInfo($sources = null) {

        $fileName = 'betcklick_feed_' . date('Y-m-d H') . '.xml';
        $filePath = TMP . 'feeds' . DS . $fileName;

        $eventsInfo = array();

        if (!file_exists($filePath)) {
            $get = file_get_contents('http://xml.cdn.betclic.com/odds_en.xml');
            $put = file_put_contents($filePath, $get);
        }


        if (file_exists($filePath)) {
            $xmlFeed = new SimpleXMLElement(file_get_contents($filePath));

            $xpathMatches = '//sport/event[@name="World Cup"]/match[@live_id!=""]';
            $wc2014Events = $xmlFeed->xpath($xpathMatches);

            foreach ($wc2014Events as $match) {

                $event_id = (string) ($match->attributes()->id);

                // Event

                $aEventData = array(
                    'Event' => array(
                        'id' => $event_id,
                        'title' => (string) $match->attributes()->name,
                        'start_date' => (string) $match->attributes()->start_date,
                    )
                );

                $aEventData['Event']['hash'] = md5('IcWc2014' . json_encode($aEventData['Event']));

                // Odds

                $matchOdds = $match->xpath('bets/bet[@name="Match Result" or @name="Double Chance"]/choice');

                foreach ($matchOdds as $odd) {
                    $odd_tmp = array(
                        'id' => (string) $odd->attributes()->id,
                        'name' => (string) str_replace('%', '', $odd->attributes()->name),
                        'odd' => round((1.05) * (float) (string) str_replace('%', '', $odd->attributes()->odd), 2),
                        'event_id' => $event_id
                    );
                    $odd_tmp['hash'] = md5('IcWc2014' . json_encode($odd_tmp));
                    $aEventData['Odd'][] = $odd_tmp;
                }

                $eventsInfo[md5(json_encode($aEventData))] = $aEventData;
            }

            return $eventsInfo;
        }
    }

}


