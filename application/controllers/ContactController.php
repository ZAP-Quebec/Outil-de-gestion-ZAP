<?php
/**
 * Router Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Router Controller Class
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class ContactController extends Zend_Controller_Action {
    /**
     * Init
     */
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->user = Zend_Auth::getInstance()->getIdentity();
        $this->view->user = $this->user;
    }
    /**
     * Add request action
     */
    function addAction() {
        $form = new ContactForm();
        $form->submit->setLabel('Ajouter');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $contacts = new Contacts();
                $row = $contacts->createRow();
                $row->lastname = $form->getValue('lastname');
                $row->firstname = $form->getValue('firstname');
                $row->email = $form->getValue('email');
                $row->office_phone = $form->getValue('office_phone');
                $row->home_phone = $form->getValue('home_phone');
                $row->notes = $form->getValue('notes');

                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'CONTACT', 'ADD', $row->toArray());

                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }

    /**
     * Request list
     */
    function listAction() {
        $contacts = new Contacts();
        $this->view->contacts = $contacts->fetchAll(null, 'lastname');
    }

    /**
     * View
     */
    function viewAction() {
        $form = new ContactForm();
        $form->submit->setLabel('Enregistrer');
        $form->setAction($this->_request->getBaseUrl().'/contact/update');
        $this->view->form = $form;


            $id = $this->_request->getParam('id', 0);
            if ($id > 0) {
                $contacts = new Contacts();
                $contact = $contacts->fetchRow("id_contact = '".$id."'");
                $form->populate($contact->toArray());
            }

    }

    /**
     * Update user
     */
    function updateAction() {
        $form = new ContactForm();
        $form->submit->setLabel('Enregistrer');
        $form->setAction($this->_request->getBaseUrl().'/contact/update');
        $this->view->form = $form;

                if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $contacts = new Contacts();
                $id = $form->getValue('id_contact');
                $row = $contacts->fetchRow("id_contact = '".$id."'");
                $oldValue = $row->toArray();

                $row->firstname = $form->getValue('firstname');
                $row->email = $form->getValue('email');
                $row->office_phone = $form->getValue('office_phone');
                $row->home_phone = $form->getValue('home_phone');
                $row->notes = $form->getValue('notes');

                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'CONTACT', 'UPDATE', $row->toArray(), $oldValue);

                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
}
 }
