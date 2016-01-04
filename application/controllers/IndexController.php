<?php
//product controller
class IndexController extends Zend_Controller_Action
{
    function indexAction()
    {   
        $rows = Product::loadAll();
         $this->view->products = $rows;
    }
    public function searchAction(){
        $rows = Product::searchByName($this->getParam('search'));
         $this->view->products = $rows;
        $this->render('index');
    }
    function addAction()
    {
        $this->view->title = "Add New Product";
        $form = new ProductForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $products = new Product();
                $row = $products->createRow();
                $row->product_name = $form->getValue('product_name');
                $row->product_id = $form->getValue('product_id');
                $row->product_desc = $form->getValue('product_desc');
                $row->category_id = $form->getValue('category_id');
                $row->product_image = $form->getValue('product_image');  
                $row->save();
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }
    function editAction()
    {
        $this->view->title = "Product";
        $form = new ProductForm();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();

            //removed validation on edit
            $form->getElement('product_id')->removeValidator('Db_NoRecordExists');
            if ($form->isValid($formData)) {
                $products = new Product();
                $id = (int)$form->getValue('id');
                $row = $products->fetchRow('id='.$id);

                $row->product_name = $form->getValue('product_name');
                $row->product_id = $form->getValue('product_id');
                $row->product_desc = $form->getValue('product_desc');
                $row->product_desc = $form->getValue('product_desc');
                $row->product_image = $form->getValue('product_image');  
                $row->category_id = $form->getValue('category_id');
                $row->product_image = $form->getValue('product_image');  
                $row->save();
                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $products = new Product();
                $product = $products->fetchRow('id='.$id);
                $form->populate($product->toArray());
            }
        }
    }
    function deleteAction()
    {
        $this->view->title = "Delete Product";
        if ($this->_request->isPost()) {
            $id = (int)$this->_request->getPost('id');
            $del = $this->_request->getPost('del');
            if ($del == 'Yes' && $id > 0) {
                $products = new Product();
                $where = 'id='.$id;
                $products->delete($where);
            }
            $this->_redirect('/');
        } else {
            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
                $product = new Product();
                $this->view->product = $product->fetchRow('id='.$id);
            }
        }
    }   
}
