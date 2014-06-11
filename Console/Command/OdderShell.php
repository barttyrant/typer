<?php

class OdderShell extends Shell {
    
    public $uses = array('Odd', 'Event', 'User', 'Bet');
    

    public function _welcome(){}
    
    public function main() {        
        die('no method called');
    }
    
    public function fetch_events() {
        $events = $this->Event->fetchEventsInfo();

//        pr($events);
        
                
        $savedFetchedData = $this->Event->saveFetchedInfo($events);
//        if(!empty($savedFetchedData)){
//            $message[0] = __('Retrieved data from Betclick', true);
//            if(!empty($savedFetchedData['evSaved'])){
//                $message[] = __('Saved %s new events', $savedFetchedData['evSaved']);
//            }
//            if(!empty($savedFetchedData['odSaved'])){
//                $message[] = __('Saved %s new odds', $savedFetchedData['odSaved']);
//            }
//            if(!empty($savedFetchedData['odUpdat'])){
//                $message[] = __('Update %s existing odds', $savedFetchedData['odUpdat']);
//            }
//
//            $this->out(date('Y-m-d H:i:s') . ' - SUCC: ' . join(', ', $message));
//        }
//        else{
//            $this->out(date('Y-m-d H:i:s') . ' - ERR: Unable to update events/odds. Something is fuched up :/');
//        }
    }


    
}