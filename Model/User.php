<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Role $Role
 * @property Group $Group
 */
class User extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';

	
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';
    
    const LOGIN_MIN_LENGTH = 4;
    const LOGIN_MAX_LENGTH = 60;
    const FIRSTNAME_MIN_LENGTH = 2;
    const FIRSTNAME_MAX_LENGTH = 40;
    const LASTNAME_MIN_LENGTH = 2;
    const LASTNAME_MAX_LENGTH = 40;
    const PASSWORD_MIN_LENGTH = 7;
    const PASSWORD_MAX_LENGTH = 40;
    
    const DEFAULT_POINTS_AMMOUNT = 100;
    const DEFAULT_DEPOSIT = 20;
    
    const STATUS_NEW = 'NEW';
    const STATUS_ACCEPTED = 'ACCEPTED';
    
    public $validate = array();
    
    public $hasMany = array('Bet');
    
    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        $this->_prepareValidationRules();
    }
    
    protected function _prepareValidationRules(){
        $this->validate = array(
            'login' => array(
                'alphaNumeric' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __('Only alphanumeric characters are allowed in this field', true)
                ),
                'between' => array(
                    'rule' => array('between', self::LOGIN_MIN_LENGTH, self::LOGIN_MAX_LENGTH),
                    'message' => __('The lenght of this field must be between %1$s and %2$s characters', self::LOGIN_MIN_LENGTH, self::LOGIN_MAX_LENGTH)
                ),
                'unique' => array(
                    'rule' => 'isUnique',
                    'message' => __('This value must be unique in database. Currently, it isn\'t', true)
                )
            ),
            'first_name' => array(
                'alphaNumeric' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __('Only alphanumeric characters are allowed in this field', true)
                ),
                'between' => array(
                    'rule' => array('between', self::FIRSTNAME_MIN_LENGTH, self::FIRSTNAME_MAX_LENGTH),
                    'message' => sprintf(__('The lenght of this field must be between %1$s and %2$s characters', self::FIRSTNAME_MIN_LENGTH, self::FIRSTNAME_MAX_LENGTH))
                ),
            ),
            'last_name' => array(
                'alphaNumeric' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __('Only alphanumeric characters are allowed in this field', true)
                ),
                'between' => array(
                    'rule' => array('between', 2, 30),
                    'message' => __('The lenght of this field must be between 2 and 30 characters', true)
                ),
            ),
            'gender' => array(
                'zero_one' => array(
                    'rule' => array('inList', array(self::GENDER_FEMALE, self::GENDER_MALE)),
                    'message' => __('Hmmm, sorry but this gender looks a bit strange even for these days...', true)
                )
            ),
            'password_' => array(
                'between' => array(
                    'rule' => array('between', self::PASSWORD_MIN_LENGTH, self::PASSWORD_MAX_LENGTH),
                    'message' => __('The lenght of Your password must be between %1$s and %2$s characters', self::PASSWORD_MIN_LENGTH, self::PASSWORD_MAX_LENGTH),
                    'allowEmpty' => false
                ),
                'repeat_valid' => array(
                    'rule' => '_repeatValid',
                    'message' => __('Passwords must be equal', true),                    
                )
            )
        );
    }
    
    /**
     * Creates new user
     * @param array $data
     * @param array $params
     * @return ...
     */
    public function addNew($data, $params = array()){        
        $defaultData = array(
            'role' => self::ROLE_USER,
            'status' => self::STATUS_NEW
        );
        
        if(isset($data['User'])){
            $data = $data['User'];
        }
        
        $data = array_merge($defaultData, $data);
        $this->create();
        return $this->save($data, $params);
    }
    
    
    public function getGenders(){
        return array(
            self::GENDER_MALE => __('male', true),
            self::GENDER_FEMALE => __('female', true),
        );
    }
    
    public function getStatuses(){
        return array(
            self::STATUS_ACCEPTED => __('accepted', true),
            self::STATUS_NEW => __('new', true),
        );
    }
    
    protected function _repeatValid($field){
        return 
            !empty($this->data['User']['password_']) 
        &&  !empty($this->data['User']['password_repeat'])
        &&  $this->data['User']['password_'] == $this->data['User']['password_repeat'];
    }
    
    
    
}
