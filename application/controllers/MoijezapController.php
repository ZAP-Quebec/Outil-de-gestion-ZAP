<?php

class MoijezapController extends Zend_Controller_Action
{
    public function preDispatch()
    {

    }

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $moijezap = new ZAP_Model_Moijezap();
        $this->view->entries = $moijezap->fetchAll();
    }

    public function updateAction()
    {
        $request = $this->getRequest();
        $form    = new ZAP_Form_Moijezap();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Moijezap($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_places = new ZAP_Model_Moijezap();
                  $oldValue = $old_places->getPlace($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'MOIJEZAP_PLACES', 'UPDATE', $form->getValues(), $oldValue);
                
                $places->save();
                return $this->_helper->redirector('index');
            }
        }
        
		$id = $this->_getParam('id', 0);
		if ($id > 0) {
		  $places = new ZAP_Model_Moijezap();
		  $form->populate($places->getPlace($id));
		}

        $this->view->form = $form;
    }
	
    public function deleteAction()
    {
        
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Oui') { 
                $id = $this->getRequest()->getPost('id');
                $places = new ZAP_Model_Moijezap();
                             
                $log = new ZAP_Model_Log();
                $log->add($id, 'MOIJEZAP_PLACES', 'DELETE', $places->getPlace($id));
                
                $places->delete($id);
            }
            return $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $places = new ZAP_Model_Moijezap();
            $this->view->place = $places->getPlace($id);
        } 
    }

}



