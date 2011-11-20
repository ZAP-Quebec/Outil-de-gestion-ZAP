<?php
/**
 * Customer Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Customer Controller Class
 *
 * @version    1.0
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class CustomerController extends Zend_Controller_Action {
    /**
     * Init
     */
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();

    }

    /**
     * List
     */
    function indexAction() {
        $this->view->messages = ($this->_helper->flashMessenger->getMessages());
        $customers = new ZAP_Model_Customers();
        $this->view->entries = $customers->fetchAll();
    }
    
    public function addAction() {
        $request = $this->getRequest();
        $form    = new ZAP_Form_Customers();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $customer = new ZAP_Model_Customers($form->getValues());

                $result = $customer->save();
                
                $log = new ZAP_Model_Log();
                $log->add($result, 'CUSTOMER', 'ADD', $form->getValues());
                $this->_helper->FlashMessenger('Client ajouté');
                return $this->_helper->redirector->gotoUrl('customer/update/id/'.$result);
            }
        }
        $this->view->form = $form;
    }
    
    
    /**
     * Delete customer
     */
    public function deleteAction()
    {
        $request = $this->getRequest();

        $customer = new ZAP_Model_Customers();

        $id = $this->_getParam('id', 0);
    
        $log = new ZAP_Model_Log();
        $log->add($id, 'CUSTOMER', 'DELETE');
                
                
        $customer->delete($id);

        $this->_helper->FlashMessenger('Client supprimé');
        return $this->_helper->redirector('index');
    }
    
    /**
     * View customer
     */
    public function updateAction()
    {
        $this->view->messages = ($this->_helper->flashMessenger->getMessages());
        $request = $this->getRequest();
        $form    = new ZAP_Form_Customers();
        $formComment    = new ZAP_Form_Comment();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $customer = new ZAP_Model_Customers($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $customer->setId($id);
                  $old_places = new ZAP_Model_Customers();
                  $oldValue = $old_places->getCustomer($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'CUSTOMER', 'UPDATE', $form->getValues(), $oldValue);
                
                $customer->save();
                $this->_helper->FlashMessenger('Enregistré');
                return $this->_helper->redirector->gotoUrl('customer/update/id/'.$id);
                //return $this->_helper->redirector('index');
            } else {
                // 2011-02-22 test validation
                $errors   = $form->getErrors();
                $messages = $form->getMessages();
                $this->view->error = 'Données non valides!';
                print_r($errors);
                die();
                $this->view->error = print_r($errors)."- test -".print_r($messages);
            }
        }
        
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $customer = new ZAP_Model_Customers();
                  $form->populate($customer->getCustomer($id));
                  //print_r($customer->getCustomer($id));
                  //die();
                  
                    // Comments
                    $comments = new ZAP_Model_Comments();
                    $this->view->comments = $comments->fetchByRequest($id, 'customer');
                    
                    // Invoice
                    $invoices = new ZAP_Model_Invoices();
                    $this->view->invoices = $invoices->fetchByCustomer($id);
                }

        $this->view->form = $form;
        $this->view->customer_id = $id;
        $this->view->formComment = $formComment;
    }
    
    /*
    function viewAction() {
        Zend_Loader::loadClass('Zend_Filter_StripTags');
        $f = new Zend_Filter_StripTags();
        $id_node = $f->filter($this->_request->getParam('id_node'));

        Zend_Loader::loadClass('NodeWifidog');
        $node_wifidog = NodeWifidog::View($id_node);
        $this->view->node_wifidog = $node_wifidog;
        $this->view->node_deployment_status = NodeWifidog::getStatus($node_wifidog->node_deployment_status);

        preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->home_page_url, $matches);
        $this->view->home_page_domain = $matches[1];

        preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->map_url, $matches);
        $this->view->map_domain = $matches[1];

        Zend_Loader::loadClass('Node');
        $node = Node::View($id_node);
        if ($node) {
            $this->view->node = $node;
        } else {
            $node = Node::Add($id_node);
            $node = Node::View($id_node);
        }


        Zend_Loader::loadClass('Contact');
        $this->view->contacts_option = Contact::listOption();
        
        $this->view->contact_administration_complete_name = Contact::getCompleteName($node->contact_administration);
        $this->view->contact_technical_complete_name = Contact::getCompleteName($node->contact_technical);
    }
*/


    }