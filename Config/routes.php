<?php

Router::connect('/', array('controller' => 'users', 'action' => 'start'));


Router::connect('/admin', array('controller' => 'users', 'action' => 'dashboard', 'admin' => true));

Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
Router::connect('/events', array('controller' => 'events', 'action' => 'index'));
Router::connect('/ranking', array('controller' => 'users', 'action' => 'ranking'));
Router::connect('/user-bets/*', array('controller' => 'users', 'action' => 'by_user'));


Router::connect('/:page', array('controller' => 'pages', 'action' => 'display'), array(
    'pass' => array('page'),
    'page' => '[A-Za-z0-9\-]+'
));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';


