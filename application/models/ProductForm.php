<?php
class ProductForm extends Zend_Form
{
public function __construct($options = null)
{
parent::__construct($options);
$this->setName('product');
    
$product_name = new Zend_Form_Element_Text('product_name');
$product_name->setLabel('Product Name: ')
->setRequired(true)
->addFilter('StripTags')
->addFilter('StringTrim')
->addValidator('NotEmpty');
$id = new Zend_Form_Element_Hidden('id');    
 $ProductIdExists = new Zend_Validate_Db_NoRecordExists(
        array(
            'table' => 'products',
            'field' => 'product_id',
           //  'exclude' => array ('field' => 'id', 'value' => $id)
        )
    );

    $ProductIdExists->setMessage('This Product ID is already taken');    
    
$product_id = new Zend_Form_Element_Text('product_id');
$product_id->setLabel('Product ID: ')
->setRequired(true)
->addFilter('StripTags')
->addFilter('StringTrim')
->addValidator($ProductIdExists)
->addValidator('NotEmpty');
    
     
    
     $category = new Category;
    $categoriesList = $category->getCategoriesList();
                       
$category_id = new Zend_Form_Element_Select('category_id');
$category_id->setLabel('Category: ')
->addMultiOptions( $categoriesList)
->setRequired(true)
->addFilter('StripTags')
->addFilter('StringTrim')
->addValidator('NotEmpty');

    $product_desc = new Zend_Form_Element_Text('product_desc');
    $product_desc->setLabel('Description ')
->addFilter('StripTags')
->addFilter('StringTrim')
->addValidator('NotEmpty');


    $product_img = new Zend_Form_Element_File('product_image');
$product_img->setLabel('Upload an image:')
        ->setDestination(PUBLIC_PATH.'/images');
// ensure only 1 file
$product_img->addValidator('Count', false, 1);
// limit to 100K
$product_img->addValidator('Size', false, 102400);
// only JPEG, PNG, and GIFs
$product_img->addValidator('Extension', false, 'jpg,png,gif');

    
    
    $submit = new Zend_Form_Element_Submit('submit');
$submit->setAttrib('id', 'submitbutton');
    $this->setAttrib('enctype', 'multipart/form-data');
$this->addElements(array($product_name, $product_id,$product_desc,$product_img,$id,$category_id, $submit));
}
}