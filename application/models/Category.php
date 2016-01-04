<?php 
class Category extends Zend_Db_Table
{
    protected $_name = 'categories';

    public function getCategoriesList()
    {
        $select  = $this->_db->select()->from($this->_name,array('key' => 'id','value' => 'name'));
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
}