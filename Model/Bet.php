<?php
App::uses('AppModel', 'Model');
/**
 * Bet Model
 *
 * @property User $User
 * @property Event $Event
 * @property Odd $Odd
 */
class Bet extends AppModel {


    const STATUS_PENDING = 'PENDING';
    const STATUS_FINISHED = 'FINISHED';
    
    const RESULT_CORRECT = 'CORRECT';
    const RESULT_INCORRECT = 'INCORRECT';
    const RESULT_UNKNOWN = 'UNKNOWN';
    

    public $validate = array();
    
	public $belongsTo = array(
		'User', 'Event', 'Odd'
	);
    
    
    
    
    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        $this->_prepareValidationRules();
    }
    
    
    protected function _prepareValidationRules(){
        $this->validate = array(
            'odd_id' => array(
                'rule' => '_validOnePerUserPerEvent',
                'message' => __('Sorry, You\'ve already taken a bet related to this event', true)
            )
        );
    }
    
    public function getAllByUser($userId, $params = array()) {
        $defaultParams = array(            
            'contain' => array('Odd', 'Event'),
            'order' => 'Bet.created DESC'
        );
        
        $defaultConditions = array('Bet.user_id' => $userId);
        
        $params = array_merge($defaultParams, $params);
        $params['conditions'] = isset($params['conditions']) ? array_merge($defaultConditions, $params['conditions']) : $defaultConditions;

        $bets = $this->find('all', $params);
        
        return $bets;
    }
    
    public function evaluate($bet, $home, $away){
        $oddName = trim(strtolower($bet['Odd']['name']));
        $result = self::RESULT_UNKNOWN;
        $outcomeCorrect = false;
        switch($oddName){
            case '1':   
                $outcomeCorrect = $home > $away;
                break;
            
            case 'remis':
            case 'x':                
                $outcomeCorrect = $home == $away;
                break;
            
            case '2':                
                $outcomeCorrect = $home < $away;
                break;
            
            case '1x':
            case '1 lub remis':  
                $outcomeCorrect = $home >= $away;
                break;
            
            case 'x2':
            case 'remis lub 2':                
                $outcomeCorrect = $home <= $away;
                break;
            
            case '12':
            case '1 lub 2':              
                $outcomeCorrect = $home <> $away;
                break;
        }
        
        if($outcomeCorrect){
            $result = self::RESULT_CORRECT;
        }
        else{
            $result = self::RESULT_INCORRECT;
        }
        
        return $this->updateAll(array(
            'Bet.status' => '"' . self::STATUS_FINISHED . '"',
            'Bet.result' => '"' . $result . '"'
        ), array('Bet.id' => $bet['Bet']['id']));

    }
    
    
    public function _validOnePerUserPerEvent($value) {
        return true;
    }
    
    public static function getRandomCorrectLabel(){
        $labels = array(
            'Heja !!!!!',
            'Siadło :)',
            'Paszło !',
            'Vamos !',
            'Jak w masło....'
        );
        
        return $labels[rand(0, count($labels)-1)];
    }
    
    public static function getRandomIncorrectLabel(){
        $labels = array(
            'Eeeeehh :/',
            'Ni CHUJA !!',
            'Noż kurwa!',
            'A niech to dundel świśnie !',
            'Ja pierdole, no znowu nie siadło :('
        );
        
        return $labels[rand(0, count($labels)-1)];
    }
    
    public static function getRandomUnknownLabel(){
        $labels = array(
            '?',
            'Pending...',
            'Waiting...'
        );
        
        return $labels[rand(0, count($labels)-1)];
    }
    
}
