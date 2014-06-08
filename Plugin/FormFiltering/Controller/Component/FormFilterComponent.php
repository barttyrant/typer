<?php
/**
 * Dedicated component for filtering data sent through the forms
 * @version 1.0
 * @author Bart Tyrant
 * 
 * @property AppController $controller
 */
class FormFilterComponent extends Component {

    public $controller = null;
    
    protected $_settings = null; //setSettings
    
    
    protected $_defaultSettings = array(
        
    );


    function initialize(Controller $controller) {
        $this->controller =& $controller;        
//        $this->setSettings($settings);
    }
    
    /**
     * sets up the component settings
     * @param array $settings 
     */
    public function setSettings($settings) {
//        $this->_settings = array_merge($this->_defaultSettings, $settings);
    }
    
    
    
    public function startup(Controller $controller){
        $data = $this->controller->request->data;
        
        if(!empty($data)){
            array_walk_recursive($data, array($this, '_filterData'));
        }        
    }
    
    
    protected function _filterData(&$value, $key){
        $value = trim($value);        
    }
    
    
}