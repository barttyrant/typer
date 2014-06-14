<?php

class OdderShell extends Shell {

    public $uses = array('Odd', 'Event', 'User', 'Bet');

    public function _welcome() {

    }

    public function main() {
        die('no method called');
    }

    public function fetch_events() {
        $events = $this->Event->fetchEventsInfo();

        $savedFetchedData = $this->Event->saveFetchedInfo($events);
        if (!empty($savedFetchedData)) {
            $message[0] = __('Retrieved data from Betclick', true);
            if (!empty($savedFetchedData['evSaved'])) {
                $message[] = __('Saved %s new events', $savedFetchedData['evSaved']);
            }
            if (!empty($savedFetchedData['odSaved'])) {
                $message[] = __('Saved %s new odds', $savedFetchedData['odSaved']);
            }
            if (!empty($savedFetchedData['odUpdat'])) {
                $message[] = __('Update %s existing odds', $savedFetchedData['odUpdat']);
            }

            $this->out(date('Y-m-d H:i:s') . ' - SUCC: ' . join(', ', $message));
        } else {
            $this->out(date('Y-m-d H:i:s') . ' - ERR: Unable to update events/odds. Something is fuched up :/');
        }
    }

    public function check_margins() {
        $activeEvents = $this->Event->find('all', array(
            'contain' => array('Odd'),
            'conditions' => array(
                'Event.start_date >' => date('Y-m-d H:i:s')
            )
        ));

        foreach ($activeEvents as $event) {
            $avg = (1 / $event['Odd'][0]['value']) + (1 / $event['Odd'][1]['value']) + (1 / $event['Odd'][2]['value']);
            $this->out($avg . ' - ' . $event['Event']['title']);
        }
    }

    public function correct_event_dates() {
        $events = $this->Event->find('all');
        foreach ($events as $ev) {
            $newDate = date('Y-m-d H:i:s', strtotime($ev['Event']['start_date']) + 3600);
            $this->Event->updateAll(array(
                'start_date' => '"' . $newDate . '"',
            ), array('Event.id' => $ev['Event']['id']));
        }
    }

}
