<?php
/**
 * Request Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */
 
/**
 * Request Controller Class
 *
 * @version    1.0
 * @since      Class available since Release 1.0
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */
class RequestController extends Zend_Controller_Action {

    public function indexAction() {
        $id = $this->_request->getParam('id', 0);
        $requests = new ZAP_Model_Requests();

        if ($id) {
            $this->view->entries = $requests->fetchByUser($id);
            $this->view->myRequests = TRUE;
        } else {
            $this->view->entries = $requests->fetchAll();
        }
    }

    public function addAction() {
        $request = $this->getRequest();
        $form    = new ZAP_Form_Request();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Requests($form->getValues());
                $id = $places->save();
                $this->_helper->FlashMessenger('Demande ajoutée');
                return $this->_helper->redirector->gotoUrl('/request/update/id/'.$id);
            }
        }
        $this->view->form = $form;
    }
    
    public function updateAction()
    {
        $this->view->messages = ($this->_helper->flashMessenger->getMessages());
        $request = $this->getRequest();
        $form    = new ZAP_Form_Request();
        $formComment    = new ZAP_Form_Comment();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Requests($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_places = new ZAP_Model_Requests();
                  $oldValue = $old_places->getRequest($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'MOIJEZAP_PLACES', 'UPDATE', $form->getValues(), $oldValue);
                
                $places->save();
                $this->_helper->FlashMessenger('Demande modifiée');
                return $this->_helper->redirector->gotoUrl('/request/update/id/'.$id);
            }
        }
        
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
          $places = new ZAP_Model_Requests();
          $form->populate($places->getRequest($id));
          
          // Comments
          $comments = new ZAP_Model_Comments();
          $this->view->comments = $comments->fetchByRequest($id, 'request');
        }

        $this->view->form = $form;
        $this->view->formComment = $formComment;
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

    function ad2dAction()
    {
        $form = new RequestForm(array('noDateClose' => true));
        $form->submit->setLabel('Ajouter');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $requests = new Requests();
                $row = $requests->createRow();
                $row->status = 'new';
                $row->date_open = $form->getValue('date_open');
                $row->summary = $form->getValue('summary');
                $row->id_node = $form->getValue('id_node');
                $row->id_user = $form->getValue('id_user');
                $row->id_user_assigned = $form->getValue('id_user_assigned');
                $row->priority = $form->getValue('priority');
                $row->description = $form->getValue('description');
                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'REQUEST', 'ADD', $row->toArray());

                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        } else {
            $formData = array('date_open' => date('Y-m-d H:i'));
            $form->populate($formData);
        }
    }

    /**
     * List
     */
    function listAction() {
        $id = $this->_request->getParam('id', 0);

        if ($id > 0) {
            $requests = new Requests();
            $this->view->requests = $requests->fetchAll("id_user = '".$id."'");
        } else {
            $requests = new Requests();
            $this->view->requests = $requests->fetchAll();
        }
    }

    /**
     * View
     */
    function viewdAction() {
        $form = new RequestForm();
        $form->submit->setLabel('Enregistrer');
        $form->setAction($this->_request->getBaseUrl().'/request/update');
        $this->view->form = $form;

            $id = $this->_request->getParam('id', 0);
            if ($id > 0) {
                $requests = new Requests();
                $request = $requests->fetchRow("id_request = '".$id."'");
                $form->populate($request->toArray());
            }
    }

    /**
     * Update request
     */
    function updadddteAction() {
        $form = new RequestForm();
        $form->submit->setLabel('Enregistrer');
        $form->setAction($this->_request->getBaseUrl().'/request/update');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $requests = new Requests();
                $id = $form->getValue('id_request');
                $row = $requests->fetchRow("id_request = '".$id."'");
                $oldValue = $row->toArray();

                $row->date_open = $form->getValue('date_open');
                $row->summary = $form->getValue('summary');
                $row->id_node = $form->getValue('id_node');
                $row->id_user = $form->getValue('id_user');
                $row->id_user_assigned = $form->getValue('id_user_assigned');
                $row->priority = $form->getValue('priority');
                $row->description = $form->getValue('description');

                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'REQUEST', 'UPDATE', $row->toArray(), $oldValue);

                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }

    /**
     * View request_comment action
     * Update request_comment action
     */
    function vieddwCommentAction() {
        // Traitement des parametres
        $id_request_comment = $this->_request->getParam('id_request_comment');

        Zend_Loader::loadClass('Request');
        $information = Request::viewComment($id_request_comment);
        
        $this->view->information = $information;
        $this->view->comment = str_replace("\'", "'", $information->comment);
        
        $this->view->request = Request::getSummary($information->id_request);
        
        Zend_Loader::loadClass('User');
        $this->view->user = User::getCompleteName($information->id_user);

        // Variables
        $id_request = $information->id_request;
        
        // Requete
        if ($this->_request->isPost()) {
            // Traitement des variables POST
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            $comment = $f->filter($this->_request->getPost('comment'));
            
            // Verification avant enregistrement
            Zend_Loader::loadClass('Zend_Validate');
            
            $error = '';
            
            Zend_Loader::loadClass('Zend_Validate_NotEmpty');
            $validator = new Zend_Validate_NotEmpty();
            if (!$validator->isValid($comment)) {
                $error .= 'Veuillez indiquer un commentaire<br />';
            }
            
            // Enregistrement
            if ($error) {
                $this->view->error = $error;
            } else {
                // Enregistrement
                Zend_Loader::loadClass('Request');
                Request::updateComment($id_request_comment, $comment);

                // Redirection
                $this->_redirect($this->baseUrl.'/request/view/'.$id_request);
            }
        }
        

    }
    
    /**
     * Delete request_comment action
     */ 
    function deletddeCommentAction() {
        // Traitement des parametres

        $id_request_comment = $this->_request->getParam('id_request_comment');
        
        // Affichage de la demande
        Zend_Loader::loadClass('Request');
        $information = Request::viewComment($id_request_comment);
        $this->view->information = $information;
        
        // Variables
        $id_request = $information->id_request;
        
        // Requ�te
        if ($this->_request->isPost()) {
            // Traitement des variables POST
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            $confirmation = $f->filter($this->_request->getPost('confirmation'));
            
            if ($confirmation == 'yes') {
                // Supprimer la demande
                Zend_Loader::loadClass('Request');
                Request::deleteComment($id_request_comment, $id_request);
            }
            
            // Redirection
            $this->_redirect($this->baseUrl.'/request/view/'.$id_request);
        }
    }

}
