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
class CommentController extends Zend_Controller_Action {

    public function indexAction() {
        /*$id = $this->_request->getParam('id', 0);
        $requests = new ZAP_Model_Requests();

        if ($id) {
            $this->view->entries = $requests->fetchByUser($id);
            $this->view->myRequests = TRUE;
        } else {
            $this->view->entries = $requests->fetchAll();
        }*/
    }

    public function addAction() {
        $request = $this->getRequest();
        $form    = new ZAP_Form_Comment();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $comment = new ZAP_Model_Comments($form->getValues());

                $auth = Zend_Auth::getInstance();
                $comment->Id_user = $auth->getIdentity()->id_user;
                $comment->Module = $this->_getParam('module', 0);
                $comment->Id_reference = $this->_getParam('reference', 0);
                $comment->Status = TRUE;
                $comment->Date = date('Y-m-d H:i');
                $comment->Time = date('H:i');

                $id = $comment->save();
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'COMMENTS', 'ADD', $form->getValues());
                 
                $this->_helper->FlashMessenger('Commentaire ajouté');
                return $this->_helper->redirector->gotoUrl($this->_getParam('module', 0).'/update/id/'.$comment->Id_reference);
            }
        }
        $this->view->form = $form;
    }
    
    public function updateAction()
    {
        $request = $this->getRequest();
        $form    = new ZAP_Form_Comment();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Comments($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_comments = new ZAP_Model_Comments();
                  $oldValue = $old_comments->fetchById($id);
                }

                $log = new ZAP_Model_Log();
                $log->add($id, 'COMMENTS', 'UPDATE', $form->getValues(), $oldValue);

                $places->save();
                $this->_helper->FlashMessenger('Commentaire modifié');

                return $this->_helper->redirector->gotoUrl('/request/update/id/'.$oldValue['id_reference']);
            }
        }

        $id = $this->_getParam('id', 0);
        if ($id > 0) {
          $comments = new ZAP_Model_Comments();
          $form->populate($comments->fetchById($id));
        }

        $this->view->form = $form;
    }
    
    public function deleteAction() {
        $this->_helper->layout->disableLayout();    //disable layout
        $this->_helper->viewRenderer->setNoRender(); //suppress auto-rendering
        //the 2 lines above are very important. 
        //this action would return html tags from the layout and will look for a phtml file. 
        //we disable the layout and suppress auto-rendering of the phtml view files 
        //SO that our JSON will be echoed properly to the Javascript...
        try {
            /*if (!$this->_request->isPost()) {
                throw new Exception('Ajax Invalid action. Not post.');
            }*/
            $data = array();
            /*if ($result = $Notes->fetchRow("notes_id=".$Notes->getAdapter()->quote($_POST['notes_id'])."")->toArray()) {
                $data['notes_id']             = $result["notes_id"];
                $data['notes']                = $result["notes"];
                $data['datetime_posted'] = $result["datetime_posted"];
                $data['status']               = $result["status"];
                $json = Zend_Json::encode($data);    //basically, $data array will also be available in the JS.
            } else {
                throw new Exception('Note ID not found.');
            }*/
            $data['message'] = 'TEST voir plus';
            $json = Zend_Json::encode($data);
            echo $json; //this will echo JSON to the Javascript
            unset($json);
            unset($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }


        /*if ($this->getRequest()->isPost()) {
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
        }*/
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
