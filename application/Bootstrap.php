<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

public function _initCache(){
    $frontendOptions = array(
'lifetime' => 24 * 3600 * 7, // cache lifetime of 7 day
    'automatic_serialization' => true);    
$backendOptions = array(
    // Directory where to put the cache files
    'cache_dir' => APPLICATION_PATH .'/../tmp'
);
// getting a Zend_Cache_Core object
$cache = Zend_Cache::factory('Core',
    'File',
    $frontendOptions,
    $backendOptions
                            );
Zend_Registry::set('Cache', $cache);
}

}

