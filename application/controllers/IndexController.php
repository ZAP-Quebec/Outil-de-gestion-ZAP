<?php

class IndexController extends Zend_Controller_Action
{

    public function preDispatch()
    {
	$auth = Zend_Auth::getInstance();
	if ($auth->hasIdentity()) {
	    //$this->real_name = $auth->getIdentity()->real_name;
	} else {
	    $this->_helper->redirector('login', 'authentification');
	}
    }
    

    public function init()
    {
        /* Initialize action controller here */
        // Variables
        /*$this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();*/
    }

    public function indexAction()
    {

    }
    
    public function forbiddenAction() {
      
    }


}

