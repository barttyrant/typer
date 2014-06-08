<?php
App::uses('AppController', 'Controller');
App::uses('User', 'Model');
/**
 * Users Controller
 *
 * @property User $User
 * @property ReportComponent $Report
 * @property MathCaptchaComponent $MathCaptcha
 */
class UsersController extends AppController {

    
    public $uses = array('User', 'Event', 'News');    
    
    public function beforeFilter() {
        $this->Auth->allow('register');
        parent::beforeFilter();
    }
    
    public function start() {
        
        $this->_prepareDashBoard();
        
        $this->paginate = array(
            'News' => array('order' => 'News.created DESC', 'limit' => 3)
        );
        $news = $this->paginate('News');
        $this->set(compact('news'));
    }        
    
    
    function ranking() {
        $this->activePageLink = 'ranking';
        $allUsers = $this->User->find('all', array(
            'contain' => array(), 'conditions' => array('User.status' => User::STATUS_ACCEPTED)
        ));
        
        foreach($allUsers as &$user){
            $userBets = $this->User->Bet->getAllByUser($user['User']['id']);
            $balance = 0;
            
            $correct = $incorrect = $pending = 0;
            
            foreach ($userBets as $bet) {
                if ($bet['Bet']['status'] == Bet::STATUS_PENDING) {
                    $pending++;
                    continue;
                }
                if ($bet['Bet']['result'] == Bet::RESULT_CORRECT) {
                    $balance += ((User::DEFAULT_POINTS_AMMOUNT * $bet['Bet']['odd']) - User::DEFAULT_POINTS_AMMOUNT);
                    $correct++;
                } elseif ($bet['Bet']['result'] == Bet::RESULT_INCORRECT) {
                    $balance -= User::DEFAULT_POINTS_AMMOUNT;
                    $incorrect++;
                }
            }
            $user['User']['balance'] = $balance;
            
            $user['User']['total_bets'] = count($userBets);
            $user['User']['correct_bets'] = $correct;
            $user['User']['incorrect_bets'] = $incorrect;
            $user['User']['pending_bets'] = $pending;
            
        }        
        unset($user);
        
        usort($allUsers, array($this, '_compare'));
        
        $this->set('users', $allUsers);
    }
    
    
    public function register() {             
        
        if (!empty($this->loggedUser)):
            $this->Report->warning(
                __('Hmmm... do You really need to register while being already logged in, STUPID?', true), array('redirect' => '/')
            );
            return;
        endif;
        
        if($this->request->is('post')){
            $data = $this->request->data; 
            
            $validCaptchaAnswer = $this->MathCaptcha->validate($data['User']['captcha']);                        
            
            if (!$validCaptchaAnswer) {
                $this->Report->error(__('Basic math... invalid anwer :)))', true), array(
                    'redirect' => false
                ));  
                $this->set('captcha', $this->MathCaptcha->getCaptcha());
                $this->set('genders', $this->User->getGenders());
                return;
            }
            
            $data['User']['password'] = $this->Auth->password($data['User']['password_']);
            if($this->User->addNew($data)){
                $this->Report->success(__('New account created successfuly. Pls wait for admin approve', true), array(
                    'redirect' => '/',
                    'autohide' => 5000
                )); return;
            }
            else{
                unset($this->request->data['User']['password_']);
                unset($this->request->data['User']['password_repeat']);                
                unset($this->request->data['User']['captcha']);
                $this->Report->error(__('Unable to create the account based on Your data :(', true), array(
                    'redirect' => false
                ));
                $this->set('captcha', $this->MathCaptcha->getCaptcha());
                $this->set('genders', $this->User->getGenders());
            }            
        }
        $this->set('genders', $this->User->getGenders());
        $this->set('captcha', $this->MathCaptcha->getCaptcha());
    }

    /**
     * Auth-component's triggered login action
     * @return type 
     */
    public function login() {  
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Report->success(__('Logged in successfuly', true), array(
                    'autohide' => true,
                    'redirect' => $this->Auth->redirect()
                ));
                return;
            } else {
                unset($this->request->data['User']['password']);
                $this->Report->error(__('Invalid username or password, try again'), array('redirect' => false));
                return;
            }
        }
    }

    /**
     * Auth-component's triggered logoutaction
     * @return type 
     */
    public function logout() {        
        return $this->redirect($this->Auth->logout());
    }
    
    
    public function my_bets() {
        
        $userData = $this->Auth->user();
        
        if(empty($userData)){
            $this->Report->error(__('There\'s no spoon :)', true), array(
                'redirect' => '/'
            ));
        }
        
        $myBets = $this->User->Bet->getAllByUser($this->Auth->user('id'));      
                
        $balance = 0;
        foreach($myBets as $bet){
            if($bet['Bet']['status'] == Bet::STATUS_PENDING){
                continue;
            }
            if($bet['Bet']['result'] == Bet::RESULT_CORRECT){
                $balance += ((User::DEFAULT_POINTS_AMMOUNT * $bet['Bet']['odd']) - User::DEFAULT_POINTS_AMMOUNT);
            }
            elseif($bet['Bet']['result'] == Bet::RESULT_INCORRECT){
                $balance -= User::DEFAULT_POINTS_AMMOUNT;
            }
        }
        
        $this->set(compact('myBets', 'balance'));
    }
    
    public function by_user($userName = null){

        $userName = trim($userName);
        
        if(empty($userName)){
            $this->Report->error(__('There\'s no spoon !!', true), array(
                'redirect' => $this->_getStupidRedirect()
            )); return;
        }
        
        $userRecord = $this->User->find('first', array(
            'conditions' => array('User.login' => ($userName)),
            'contain' => array()
        ));
                
        
        if(empty($userRecord)){
            $this->Report->error(__('Invalid user, sorry Winnetou!!', true), array(
                'redirect' => $this->_getStupidRedirect()
            )); return;
        }
              
        App::uses('Event', 'Model');
        $userBets = $this->User->Bet->getAllByUser($userRecord['User']['id'], array(
            'conditions' => array(
                'Event.start_date < ' => date('Y-m-d H:i:s', strtotime('+' . Event::CLOSE_EVENT_BEFORE_START . ' seconds')
            )),
            'order' => 'Event.start_date DESC'
        ));              
                
        $balance = 0;
        foreach($userBets as $bet){
            if($bet['Bet']['status'] == Bet::STATUS_PENDING){
                continue;
            }
            if($bet['Bet']['result'] == Bet::RESULT_CORRECT){
                $balance += ((User::DEFAULT_POINTS_AMMOUNT * $bet['Bet']['odd']) - User::DEFAULT_POINTS_AMMOUNT);
            }
            elseif($bet['Bet']['result'] == Bet::RESULT_INCORRECT){
                $balance -= User::DEFAULT_POINTS_AMMOUNT;
            }
        }
        
        $this->set('user', $userRecord);
        $this->set(compact('userBets', 'balance'));
    }
    
    
    public function admin_dashboard(){
        $this->_prepareDashBoard();
    }
    
    protected function _prepareDashBoard(){
        $totalUsers = $totalCorrect = $totalIncorrect = $stake = $totalBets = $tournamentProgress = 0;
        
        $totalUsers = $this->User->find('count', array('conditions' => array('User.status' => User::STATUS_ACCEPTED)));
        
        $totalBetsFinished = $this->User->Bet->find('count', array('conditions' => array(
            'Bet.status' => Bet::STATUS_FINISHED
        )));
        $totalBetsPending = $this->User->Bet->find('count', array('conditions' => array(
            'Bet.status' => Bet::STATUS_PENDING
        )));
        
        $totalBetsCorrect = $this->User->Bet->find('count', array('conditions' => array(
            'Bet.result' => Bet::RESULT_CORRECT, 'Bet.status !=' => Bet::STATUS_PENDING
        )));
        $totalBetsIncorrect = $this->User->Bet->find('count', array('conditions' => array(
            'Bet.result' => Bet::RESULT_INCORRECT, 'Bet.status !=' => Bet::STATUS_PENDING
        )));
        
        $stake = $totalUsers * User::DEFAULT_DEPOSIT;
        
        $dateStart = strtotime('2012-06-08 18:00:00');
        $dateEnd = strtotime('2012-07-02');
        $now = strtotime(date('Y-m-d H:i:s'));
        
        $tournamentProgress = max(0, round(100*(($now - $dateStart) / ($dateEnd - $dateStart)), 2)) . '%';
        
        $this->set(compact(
            'totalUsers', 'totalBetsCorrect', 'totalBetsIncorrect', 
            'stake', 'totalBetsPending', 'totalBetsFinished', 'tournamentProgress')
        );
    }
    
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
        
        $this->paginate = array('limit' => 20);
        
        $genders = $this->User->getGenders();
        
        $users = $this->paginate();
        
        $this->set(compact('users', 'genders'));
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
        $genders = $this->User->getGenders();
		$this->set('user', $this->User->read(null, $id));
        $this->set(compact('genders'));
	}


/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $userRecord = $this->User->find('first', array(
            'conditions' => array('User.id' => $id)
        ));
		if (empty($userRecord)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);            
		}
        $genders = $this->User->getGenders();
        $statuses = $this->User->getStatuses();
		$this->set(compact('genders', 'statuses'));
        $this->set('user', $userRecord);
	}


    public function admin_accept($id = null) {
        if(is_null($id)){
            $this->Report->error(__('Invalid id', true), array('redirect' => $this->referer()));
            return;
        }
        
        if($this->User->updateAll(array(
            'User.status' => '"' . User::STATUS_ACCEPTED . '"'
        ), array('User.id' => $id))){
            $this->Report->success(__('User accepted', true), array(
                'redirect' => $this->referer(),
                'autohide' => 5000
            ));
            return;
        }
        else{
            $this->Report->error(__('Unable to accept this user, sorry :(', true), array('redirect' => $this->referer()));
            return;
        }
    }
    
    function _compare($u1, $u2){
        if($u1['User']['balance'] == $u2['User']['balance']){
            return 0;
        }
        return $u1['User']['balance'] > $u2['User']['balance'] ? -1 : 1;
    }
}
