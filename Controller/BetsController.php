<?php
App::uses('AppController', 'Controller');
App::uses('Event', 'Model');
App::uses('Odd', 'Model');
App::uses('Bet', 'Model');
/**
 * Users Controller
 *
 * @property Bet $Event
 * @property ReportComponent $Report
 */
class BetsController extends AppController {
    
    
    public $uses = array('Bet');
    
    public $components = array('Security');
    
    
    public function admin_index(){
        $this->paginate = array(
            'contain' => array('Odd'),
            'order' => 'Event.start_date ASC',
            'limit' => 8,
        );
        
        $events = $this->paginate();
        
        $this->set(compact('events'));
    }
    
    
    
    public function create() {
        if(!$this->request->is('post') || empty($this->request->data)){
            $this->Report->error(__('Unable to create a bet for You, sorry :/', true), array(
                'redirect' => $this->referer()
            )); return;
        }
        
        $chosenOdds = !empty($this->request->data['Bet']) ? $this->request->data['Bet'] : array();        
        $chosenOdds = array_filter($chosenOdds, array($this, 'nempty'));
        
        if(count($chosenOdds) != 1){
            $this->Report->error(__('Hmmm... you seem to have done something really stupid :)', true), array(
                'redirect' => $this->referer()
            )); return;
        }

        $chosenOddId = array_shift($chosenOdds);

        $oddRecord = $this->Bet->Event->Odd->find('first', array(
            'conditions' => array('Odd.id' => $chosenOddId),
            'contain' => array('Event')
        ));   
        
        if(empty($oddRecord['Odd']) || empty($oddRecord['Event'])){
            $this->Report->error(__('Unable to find such odd/event. Have You really chosen it from the offer ? Doubt it...', true), array(
                'redirect' => $this->referer()
            )); return;
        }
        
        $timeNow = strtotime(date('Y-m-d H:i:s'));
        $eventTime = strtotime($oddRecord['Event']['start_date']);
        
        $diff = $eventTime - $timeNow;
        
        if(($diff) < Event::CLOSE_EVENT_BEFORE_START){
            $this->Report->info(__('Unable to create bet for You. This event is already closed ', true), array(
                'redirect' => $this->referer(),
                'autohide' => 5000
            )); return;
        }
        
        $alreadyTakenBet = $this->Bet->find('first', array(
            'contain' => false,
            'conditions' => array(
                'Bet.user_id' => $this->Auth->user('id'),
                'Bet.event_id' => $oddRecord['Event']['id'],
            )
        ));
        
        if(!empty($alreadyTakenBet)){
            $this->Report->error(__('Cannot bet for the same event again. That would be too simple :)', true), array(
                'redirect' => $this->referer()
            )); return;
        }
        
        if(date('Y-m-d') > date('Y-m-d', strtotime($oddRecord['Event']['start_date']))){
            $this->Report->error(__('Cannot bet for the event that is already in the past. This would be really unfair, don\'t You think?', true), array(
                'redirect' => $this->referer()
            )); return;
        }
        
        $betData = array(
            'event_id' => $oddRecord['Event']['id'],
            'user_id' => $this->Auth->user('id'),
            'stake' => 10,
            'odd' => $oddRecord['Odd']['value'],
            'odd_id' => $oddRecord['Odd']['id'],
            'status' => Bet::STATUS_PENDING,
            'result' => Bet::RESULT_UNKNOWN
        );
        
        $this->Bet->create();
        if($this->Bet->save(array('Bet' => $betData))){
            $this->Report->success(__('Successfuly created a bet for You. Good luck!', true), array(
                'redirect' => $this->referer(),
                'autohide' => 5000
            )); return;
        }
        else{
            $this->Report->error(__('Unable to create a bet for You, sorry :/', true), array(
                'redirect' => $this->referer()
            )); return;
        }        
    }    
    
    function nempty($value){
        return !empty($value);
    }
    
    
    
    
    
    
    
}