<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->messages = $this->view->exception->getMessage();
        $this->view->trace = $this->view->exception->getTraceAsString();
        $this->view->request   = $errors->request;
            
            $errors = new ZAP_Model_Errors();
            $row = $errors->createRow();
            $row->date_open = date('Y-m-d H:i');
            $row->exception = $this->view->exception->getMessage();
            $row->save();
    }


}

