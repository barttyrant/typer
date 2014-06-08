<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/Model/AppModel.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       Cake.Model
 */
class AppModel extends Model {
    
    public $actsAs = array('Containable');
    
    
    /**
     * Return results array indexed by custom key (default by id)
     * @param array $results result array
     * @param string $by custom key
     * @param string $mainModel name of model
     * @return array results
     */
    function byId($results, $by = 'id', $mainModel = null, $stripModelIndex = false) {
        if (empty($mainModel)) {
            $mainModel = $this->alias;
        }
        $new = array();
        foreach ($results as $row) {
            if ($stripModelIndex) {
                $new[$row[$mainModel][$by]] = $row[$mainModel];
            } else {
                $new[$row[$mainModel][$by]] = $row;
            }
        }
        return $new;
    }
}
