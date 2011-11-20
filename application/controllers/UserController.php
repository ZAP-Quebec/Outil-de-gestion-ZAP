<?php

class UserController extends Zend_Controller_Action {

    public function indexAction()
    {
        $users = new ZAP_Model_Users();
        $this->view->entries = $users->fetchAll();
    }

    public function groupsAction()
    {
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form = new ZAP_Form_AddUser();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $usersWifidog = new ZAP_Model_UsersWifidog;
                $user_id = $usersWifidog->fetchByEmail($form->getValue('email'));
                //print_r($user);
                //die($user_id->user_id.$form->getValue('email'));
                
                //pas existant dans wifidog
                if (!$user_id) {
                  $this->view->error = "L'usager n'existe pas dans la base de donn&eacute;es de Wididog. Avez-vous le bon courriel?";
                } else {
                  // already exist on management tables
                  $users = new ZAP_Model_Users();
                  $user_id_already = $users->getUser($user_id->user_id);

                  if ($user_id_already === FALSE) {
                      $user = new ZAP_Model_Users();
                      $user->id = $user_id->user_id;
                      $user->firstname = $form->getValue('firstname');
                      $user->lastname = $form->getValue('lastname');
                      $user->save(true);

                      // log user added
                      $log = new ZAP_Model_Log();
                      $log->add($user_id_already, 'USERS', 'ADD', $form->getValues());
                  } else {
                      $this->view->error = 'L\'usager '.$form->getValue('email').' existe d&eacute;j&agrave;!';
                  }
                }
            }
        }

        $this->view->form = $form;
    }

    public function updateAction() {
        $request = $this->getRequest();
        $form = new ZAP_Form_Users();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $user = new ZAP_Model_Users($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_user = new ZAP_Model_Users();
                  $oldValue = $old_user->getUser($id);
                }

                $log = new ZAP_Model_Log();
                $log->add($id, 'USERS', 'UPDATE', $form->getValues(), $oldValue);

                $user->save();
                return $this->_helper->redirector('index');
            }
        }

        $id = $this->_getParam('id', 0);
        if ($id) {
          $places = new ZAP_Model_Users();
          $form->populate($places->getUser($id));
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