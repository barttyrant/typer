<?php
App::uses('AppController', 'Controller');
App::uses('Event', 'Model');
App::uses('Odd', 'Model');
App::uses('Bet', 'Model');
/**
 * Users Controller
 *
 * @property Event $Event
 * @property ReportComponent $Report
 */
class EventsController extends AppController {
    
    
    public $uses = array('Event');
    
    public $components = array('Security');
    
    public function beforeFilter() {
        $this->Auth->allow('fetch_events');
        parent::beforeFilter();
    }
    
    
    public function index() {
        $this->activePageLink = 'zaklady';
        $userData = $this->Auth->user();

        if (empty($userData)) {
            $this->Report->error(__('There\'s no spoon :)', true), array(
                'redirect' => '/'
            ));
        }

        $nowDate = date('Y-m-d');
//        $nowDate = '2012-06-08';

        $events = $this->Event->find('all', array(
            'contain' => array('Odd'),
            'conditions' => array(
                'Event.start_date >= ' => $nowDate,
                'Event.start_date < ' => date('Y-m-d', strtotime('3 days', strtotime($nowDate))),
            ),
            ));

        $alreadyTakenEvents = $this->User->Bet->byId($this->User->Bet->find('all', array(
                'conditions' => array(
                    'Bet.user_id' => $this->Auth->user('id'),
                )
            )), 'id', 'Event');

        $this->set(compact('alreadyTakenEvents'));
        $this->set(compact('events'));
    }
    
    public function admin_index(){
        $this->paginate = array(
            'contain' => array('Odd'),
            'order' => 'Event.start_date ASC',
            'limit' => 8,
        );
        
        $events = $this->paginate();
        
        $this->set(compact('events'));
    }
    
    
    public function admin_edit($id = null) {
        if(empty($id)){
            $this->Report->error(__('There\'s no spoon', true), array(
                'redirect' => '/'
            )); return;
        }
        
        if(!empty($this->request->data)){
            $data = $this->request->data;
            if(!isset($data['Event']['outcome_home']) || !isset($data['Event']['outcome_away']) || empty($data['Event']['id'])){
                $this->Report->error(__('Invalid data passed through the form', true), array(
                    'redirect' => $this->referer()
                )); return;
            } else{
                $outcome = $data['Event']['outcome_home'] . ' : ' . $data['Event']['outcome_away'];
                if($this->Event->updateAll(array(
                    'Event.outcome' => '"' . $outcome . '"'
                ), array('Event.id' => $id))){
                    // setting bets statuses:
                    $relatedBets = $this->Event->Bet->find('all', array(
                        'conditions' => array('Bet.event_id' => $id),
                        'contain' => array('Odd')
                    ));
                    
                    $status = true;
                    
                    if(!empty($relatedBets)){
                        foreach($relatedBets as $bet){
                           $status = $status && $this->Event->Bet->evaluate($bet, $data['Event']['outcome_home'], $data['Event']['outcome_away']);
                        } 
                    }                    
                    if($status){
                        $this->Report->success(__('Updated event result and evaluated all related bets', true), array(
                            'redirect' => array('action' => 'admin_index'),
                            'autohide' => 5000
                        ));return;
                    }
                    else{
                        $this->Report->error(__('Ooops, something\'s got fucked up :/', true), array(
                            'redirect' => $this->referer()
                        )); return;
                    }
                }
            }
        }
        
        $event = $this->Event->find('first', array(
            'conditions' => array('Event.id' => $id),
            'contain' => array('Bet')
        ));
        
        $this->request->data = $event;
        
        if(!empty($event['Event']['outcome'])){
            list(
                $this->request->data['Event']['outcome_home'], 
                $this->request->data['Event']['outcome_away']
            ) = explode(':', $event['Event']['outcome']);
            
            $this->request->data['Event']['outcome_home'] = trim($this->request->data['Event']['outcome_home']);
            $this->request->data['Event']['outcome_away'] = trim($this->request->data['Event']['outcome_away']);            
        }
        
        $this->set(compact('event'));            
    }
    
    
    public function admin_fetch_events() {
        $events = $this->Event->fetchEventsInfo();
                
        $savedFetchedData = $this->Event->saveFetchedInfo($events);
        if(!empty($savedFetchedData)){
            $message[0] = __('Retrieved data from Betclick', true);
            if(!empty($savedFetchedData['evSaved'])){
                $message[] = __('Saved %s new events', $savedFetchedData['evSaved']);
            }
            if(!empty($savedFetchedData['odSaved'])){
                $message[] = __('Saved %s new odds', $savedFetchedData['odSaved']);
            }
            if(!empty($savedFetchedData['odUpdat'])){
                $message[] = __('Update %s existing odds', $savedFetchedData['odUpdat']);
            }
            
            $this->Report->success(join(', ', $message), array(
                'redirect' => $this->referer(),
                'autohide' => 5000
            )); return;            
        }
        else{
            $this->Report->error(__('Unable to update events/odds. Something is fuched up :/', true), array(
                'redirect' => $this->referer()
            ));
        }
    }
    
    
    public function admin_correct_event_dates(){
        
        $events = array(
            array('id' => '1', 'title' => 'Polska - Grecja', 'description' => '', 'start_date' => '2012-06-08 18:00:00', 'created' => '2012-06-07 13:29:01', 'modified' => '2012-06-07 13:29:01', 'outcome' => '', 'hash' => '266aed6963c398bc008cdae9ff322e00'),
            array('id' => '2', 'title' => 'Rosja - Czechy', 'description' => '', 'start_date' => '2012-06-08 20:45:00', 'created' => '2012-06-07 13:29:01', 'modified' => '2012-06-07 13:29:01', 'outcome' => '', 'hash' => '907e45607e636d540a7d59d7357c0e85'),
            array('id' => '3', 'title' => 'Holandia - Dania', 'description' => '', 'start_date' => '2012-06-09 18:00:00', 'created' => '2012-06-07 13:29:02', 'modified' => '2012-06-07 13:29:02', 'outcome' => '', 'hash' => '93373205aba1f38d6c505c11cf38b062'),
            array('id' => '4', 'title' => 'Niemcy - Portugalia', 'description' => '', 'start_date' => '2012-06-09 20:45:00', 'created' => '2012-06-07 13:29:02', 'modified' => '2012-06-07 13:29:02', 'outcome' => '', 'hash' => 'c7f33db18a7ccf10c3f82e62365edc7a'),
            array('id' => '5', 'title' => 'Hiszpania - Włochy', 'description' => '', 'start_date' => '2012-06-10 18:00:00', 'created' => '2012-06-07 13:29:02', 'modified' => '2012-06-07 13:29:02', 'outcome' => '', 'hash' => '4d2c51ccc6da5f9afdd1acfe47b521ce'),
            array('id' => '6', 'title' => 'Irlandia - Chorwacja', 'description' => '', 'start_date' => '2012-06-10 20:45:00', 'created' => '2012-06-07 13:29:02', 'modified' => '2012-06-07 13:29:02', 'outcome' => '', 'hash' => 'f93aa521d706e277d7b8d7f20444a656'),
            array('id' => '7', 'title' => 'Francja - Anglia', 'description' => '', 'start_date' => '2012-06-11 18:00:00', 'created' => '2012-06-07 13:29:03', 'modified' => '2012-06-07 13:29:03', 'outcome' => '', 'hash' => '2abb578f75f3d2b1efaf8ea60adce0e7'),
            array('id' => '8', 'title' => 'Ukraina - Szwecja', 'description' => '', 'start_date' => '2012-06-11 20:45:00', 'created' => '2012-06-07 13:29:03', 'modified' => '2012-06-07 13:29:03', 'outcome' => '', 'hash' => 'ab36c63ea91b328f265ef8e59be3ea14'),
            array('id' => '9', 'title' => 'Grecja - Czechy', 'description' => '', 'start_date' => '2012-06-12 18:00:00', 'created' => '2012-06-07 13:29:03', 'modified' => '2012-06-07 13:29:03', 'outcome' => '', 'hash' => '706a09b3f0c8be37d3c66e15df66a3b4'),
            array('id' => '10', 'title' => 'Polska - Rosja', 'description' => '', 'start_date' => '2012-06-12 20:45:00', 'created' => '2012-06-07 13:29:03', 'modified' => '2012-06-07 13:29:03', 'outcome' => '', 'hash' => '5ed0c2999fe2dc2783b47bb4df7fc84f'),
            array('id' => '11', 'title' => 'Dania - Portugalia', 'description' => '', 'start_date' => '2012-06-13 18:00:00', 'created' => '2012-06-07 13:29:04', 'modified' => '2012-06-07 13:29:04', 'outcome' => '', 'hash' => '8fbe18fbc9bf35891da582674e35a918'),
            array('id' => '12', 'title' => 'Holandia - Niemcy', 'description' => '', 'start_date' => '2012-06-13 20:45:00', 'created' => '2012-06-07 13:29:04', 'modified' => '2012-06-07 13:29:04', 'outcome' => '', 'hash' => '1bf8500980dfac00192022faf97798d3'),
            array('id' => '13', 'title' => 'Włochy - Chorwacja', 'description' => '', 'start_date' => '2012-06-14 18:00:00', 'created' => '2012-06-07 13:29:04', 'modified' => '2012-06-07 13:29:04', 'outcome' => '', 'hash' => '547dd0cdd0bfef94a3ef976a896c1c57'),
            array('id' => '14', 'title' => 'Hiszpania - Irlandia', 'description' => '', 'start_date' => '2012-06-14 20:45:00', 'created' => '2012-06-07 13:29:04', 'modified' => '2012-06-07 13:29:04', 'outcome' => '', 'hash' => '83a63bbcf69c0989af884f17c3d61928'),
            array('id' => '15', 'title' => 'Ukraina - Francja', 'description' => '', 'start_date' => '2012-06-15 18:00:00', 'created' => '2012-06-07 13:29:05', 'modified' => '2012-06-07 13:29:05', 'outcome' => '', 'hash' => '8aa58cd451571dab13ca6ffb8ee7cabf'),
            array('id' => '16', 'title' => 'Szwecja - Anglia', 'description' => '', 'start_date' => '2012-06-15 20:45:00', 'created' => '2012-06-07 13:29:05', 'modified' => '2012-06-07 13:29:05', 'outcome' => '', 'hash' => '4bd5163d2da429ba9167cca8aed1afce'),
            array('id' => '17', 'title' => 'Czechy - Polska', 'description' => '', 'start_date' => '2012-06-16 20:45:00', 'created' => '2012-06-07 13:29:05', 'modified' => '2012-06-07 13:29:05', 'outcome' => '', 'hash' => 'ae1e7c9e7a88a96180c130e110902ea9'),
            array('id' => '18', 'title' => 'Grecja - Rosja', 'description' => '', 'start_date' => '2012-06-16 20:45:00', 'created' => '2012-06-07 13:29:05', 'modified' => '2012-06-07 13:29:05', 'outcome' => '', 'hash' => '08ea08659e888bce9c5ec9de3f3701e6'),
            array('id' => '19', 'title' => 'Portugalia - Holandia', 'description' => '', 'start_date' => '2012-06-17 20:45:00', 'created' => '2012-06-07 13:29:06', 'modified' => '2012-06-07 13:29:06', 'outcome' => '', 'hash' => '775d5ffe50ad34defdd8c43c57634422'),
            array('id' => '20', 'title' => 'Dania - Niemcy', 'description' => '', 'start_date' => '2012-06-17 20:45:00', 'created' => '2012-06-07 13:29:06', 'modified' => '2012-06-07 13:29:06', 'outcome' => '', 'hash' => '6546e2bc5132397d1ffbd04d21e672a9'),
            array('id' => '21', 'title' => 'Chorwacja - Hiszpania', 'description' => '', 'start_date' => '2012-06-18 20:45:00', 'created' => '2012-06-07 13:29:06', 'modified' => '2012-06-07 13:29:06', 'outcome' => '', 'hash' => 'e6a33d3e573bf30d4e8917e6f1f3ca94'),
            array('id' => '22', 'title' => 'Włochy - Irlandia', 'description' => '', 'start_date' => '2012-06-18 20:45:00', 'created' => '2012-06-07 13:29:06', 'modified' => '2012-06-07 13:29:06', 'outcome' => '', 'hash' => 'df5b5d6211b1c94a9e368817605a0123'),
            array('id' => '23', 'title' => 'Anglia - Ukraina', 'description' => '', 'start_date' => '2012-06-19 20:45:00', 'created' => '2012-06-07 13:29:07', 'modified' => '2012-06-07 13:29:07', 'outcome' => '', 'hash' => 'dc5d89f1289e5d8af40d0da7fdeac77c'),
            array('id' => '24', 'title' => 'Szwecja - Francja', 'description' => '', 'start_date' => '2012-06-19 20:45:00', 'created' => '2012-06-07 13:29:07', 'modified' => '2012-06-07 13:29:07', 'outcome' => '', 'hash' => '75028192601d3c39f755616a7553699c')
        );
        
        $updated = 0;
        foreach($events as $e){            
            if($this->Event->updateAll(array(
                'Event.start_date' => '"' . $e['start_date'] . '"',
            ), array('Event.title' => $e['title']))){
                $updated++;
            }
            
        }
        
        (var_dump(array('updated' => $updated)));
        die();
        
    }
    
    
    
    
    
}