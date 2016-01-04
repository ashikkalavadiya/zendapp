<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

define('BASE_PATH', realpath(dirname(__DIR__)));
define('PUBLIC_PATH', BASE_PATH.'/public');

// Ensure library/ is on include_path
//set_include_path(implode(PATH_SEPARATOR, array(
//    realpath(APPLICATION_PATH . '/../library'),
//    get_include_path(),
//)));

set_include_path('.' . PATH_SEPARATOR . '../library/'
. PATH_SEPARATOR . '../application/models'
. PATH_SEPARATOR . get_include_path());
include "Zend/Loader.php";
Zend_Loader::registerAutoload();

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// load configuration
$config = new Zend_Config_Ini('../application/config.ini', 'product');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);

// setup database
$db = Zend_Db::factory($config->db);
Zend_Db_Table::setDefaultAdapter($db);

$application->bootstrap()
            ->run();


