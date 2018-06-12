<?php

App::uses('Controller', 'Controller');
App::uses('User', 'Model');

class AppController extends Controller {
    
    public $activePageLink = 'start';
    public $metaDescription = '[Meta Description]';
    public $metaKeywords = '[Meta Keywords]';
    public $loggedUser = array();
    
    public $uses = array('User');
    
    public $components = array(
        'Session',
	    'Auth',
        'FlashReporting.Report',
        'FormFiltering.FormFilter',
        'MathCaptcha',
    );   
    
    
    
    public $helpers = array('Html', 'Form', 'Session', 'Number', 'Paginator');
    
    public function beforeFilter(){
        $this->_setUpAuth();
        $this->_checkAdminAccess();
        $this->setupMetaData();
//        $this->Security->blackHoleCallback = 'blackhole';
        $this->loggedUser = $this->Auth->user();                
        $this->set('pageLinks', $this->_getPageLinks());
        
        if(stripos($this->action, 'admin') !== false){
            $this->activePageLink = 'admin';
        }
    }


    public function setupMetaData(){
    	$this->metaDescription = Configure::read('Application.MetaDescription');
	    $this->metaKeywords= Configure::read('Application.MetaKeywords');


    }
    
    public function beforeRender(){
        $this->set(array(
            'activePageLink' => $this->activePageLink,
            'metaDescription' => $this->metaDescription,
            'metaKeywords' => $this->metaKeywords,
            'loggedUser' => $this->loggedUser
        ));        
        
        if(stripos($this->action, 'admin_') !== false){
            $this->layout = 'admin';
        }
    }
    
    protected function _setUpAuth() {
        
        $this->Auth->logoutRedirect = '/';
        $this->Auth->loginAction = array('admin' => false, 'controller' => 'users', 'action' => 'login');
        $this->Auth->authenticate = array(
            'Form' => array(
                'fields' => array('username' => 'login'),
                'scope' => array('User.status' => User::STATUS_ACCEPTED)
            )
        );
        $this->set('loggedUser', $this->Auth->user());
    }
    
    protected function _checkAdminAccess() {
        if(stripos($this->action, 'admin_') !== false){
            if($this->Auth->user('role') == User::ROLE_ADMIN){
                return true;
            }
            else{
                $this->Report->error(__('No access here, sorry :)', true), array('redirect' => false)); 
                $this->redirect('/', 403);
            }
        }
    }
    
    
    protected function _getPageLinks() {
        $links = array(
            array(
                'name' => 'start',
                'url' => '/'
            ),
            array(
                'name' => 'events',
                'url' => '/events'
            ),
            array(
                'name' => 'ranking',
                'url' => '/ranking'
            ),
            array(
                'name' => 'rules',
                'url' => '/rules'
            ),
        );
        if($this->Auth->user('role') == User::ROLE_ADMIN){
            $links[] = array(
                'name' => 'admin',
                'url' => '/admin',
                'class' => 'admin-menu-link'
            );
        }
        return $links;
    }
    
    protected function _getStupidMessage(){
        $messages = array(
            __('Thers\'s no spoon', true),
            __('Blaaaaaaaaaah...', true),
            __('Funny as hell... :)', true),
            __('Hmmm... would You feel very bad If I told You to fuck Yourself ?', true),
            __('Vypadněte odsud', true),
            __('Boring', true)
        );
        
        return $messages[rand(0, count($messages) - 1)];
    }
    
    protected function _getStupidRedirect(){
        $redirects = array(
            'http://www.radiomaryja.pl/',
            'http://dupa.pl',
            'http://sexydaisy.com/',
            'http://3.bp.blogspot.com/_yPrb5EJB9jo/SxGnvd1ycbI/AAAAAAAAAEY/3DR_rm_dCcs/s1600/1989_jaroslaw_e_lech_kaczynski.jpg',
            'http://i2.pinger.pl/pgr237/1bde2f8100206f4049b6c673/nichuja.jpg',
            '/',
            '/',            
        );
        
        return $redirects[rand(0, count($redirects) - 1)];
    }
    
    public function blackhole($type){

        $message = $this->_getStupidMessage();
        $redirect = $this->_getStupidRedirect();

        $statuses = array(
            0 => 'success',
            1 => 'info',
            2 => 'warning',
            3 => 'error'
        );

        $status = rand(0, 3);

        return $this->Report->{$statuses[$status]}($message, array(
            'redirect' => $redirect
        ));
    }
    
    
    
    protected function getHash($password) {
        die($this->Auth->password($password));
    }
    
//    public function appError($error) {
//        return $this->blackhole('');
//    }
    
}
