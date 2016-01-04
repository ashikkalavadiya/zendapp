<?php
class CachemgmtController extends Zend_Controller_Action
{
    
    function indexAction()
    {
        $cm = Zend_Registry::get('Cache');
        $CacheName = 'PRODUCTS';
        print_r($cm ->load($CacheName));
        $this->_helper->viewRenderer->setNoRender();
    } 
    public function removecacheAction()
    {
        $cm = Zend_Registry::get('Cache');
        $CacheName = 'PRODUCTS';
        $cm ->remove($CacheName);
        $this->_helper->viewRenderer->setNoRender();
         
    }
}