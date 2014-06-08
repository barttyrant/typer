#!/usr/bin/php -q
<?php
/**
 * Command-line code generation utility to automate programmer chores.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Console
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$ds = DIRECTORY_SEPARATOR;
$dispatcher = 'Cake' . $ds . 'Console' . $ds . 'ShellDispatcher.php';
$found = false;
$paths = explode(PATH_SEPARATOR, ini_get('include_path'));

foreach ($paths as $path) {
    if (file_exists($path . $ds . $dispatcher)) {
        $found = $path;
    }
}

if (!$found && function_exists('ini_set')) {
    $root = dirname(dirname(dirname(__FILE__)));
    ini_set('include_path', $root . $ds . 'lib' . PATH_SEPARATOR . ini_get('include_path'));

    /**
     * This is a workaround of the idiotic movement made by guys from CakePhp
     * when developing 2.0 version and its "cake" shell script which is probably not
     * supposed to work unless the cake core folder is thrown away from the project
     * (symlinked or sth).
     *
     * @author Bart Tyrant
     */
    if (!defined('CAKE_CORE_INCLUDE_PATH')) {
        $libPath = $root . $ds . 'lib';
        define('CAKE_CORE_INCLUDE_PATH', $libPath);
        define('DS', DIRECTORY_SEPARATOR);
        define('CAKEPHP_SHELL', true);
        if (!defined('CORE_PATH')) {
            define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
        }
    }
    // fix end
}

if (!include($dispatcher)) {
    trigger_error('Could not locate CakePHP core files.', E_USER_ERROR);
}
unset($paths, $path, $found, $dispatcher, $root, $ds);

return ShellDispatcher::run($argv);
