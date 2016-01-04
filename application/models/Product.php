<?php class Product extends Zend_Db_Table
{
protected $_name = 'products';
    
public static function loadAll(){
    $db = Zend_Db_Table::getDefaultAdapter(); 
        $select = $db->select();
        $select->from(array('p'=>'products'))
                ->joinLeft(array('c' => 'categories'), 'c.id = p.category_id', array('category_name'=>'name'));
        $rows = $db->fetchAll($select);
        $cm = Zend_Registry::get('Cache');
        $cacheArray = array();
        foreach($rows as $row){
            $cacheArray[$row['category_id']][] = $row; 
        }
        $CacheName = 'PRODUCTS';
        try{
            $cm->save($cacheArray, $CacheName);
        }catch(Exception $e){

        }
    return $rows;
}
}