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
class RouterController extends Zend_Controller_Action {
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
        $form = new RouterForm();
        $form->submit->setLabel('Ajouter');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $routers = new Routers();
                $row = $routers->createRow();

                $row->compagny = $form->getValue('compagny');
                $row->model = $form->getValue('model');
                $row->serial_number = $form->getValue('serial_number');
                $row->mac_address = $form->getValue('mac_address');
                $row->position = $form->getValue('position');
                $row->power_supply_position = $form->getValue('power_supply_position');

                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'ROUTER', 'ADD', $row->toArray());

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
        $routers = new Routers();
        $this->view->routers = $routers->fetchAll(null, 'mac_address');
    }

    /**
     * View
     */
    function viewAction() {
        $form = new RouterForm();
        $form->submit->setLabel('Enregistrer');
        $form->setAction($this->_request->getBaseUrl().'/router/update');
        $this->view->form = $form;


            $id = $this->_request->getParam('id', 0);
            if ($id > 0) {
                $routers = new Routers();
                $router = $routers->fetchRow("id_router = '".$id."'");
                $form->populate($router->toArray());
            }

    }

    /**
     * Update user
     */
    function updateAction() {
        $form = new RouterForm();
        $form->submit->setLabel('Enregistrer');
        $form->setAction($this->_request->getBaseUrl().'/router/update');
        $this->view->form = $form;

                if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $routers = new Routers();
                $id = $form->getValue('id_router');
                $row = $routers->fetchRow("id_router = '".$id."'");
                $oldValue = $row->toArray();

                $row->compagny = $form->getValue('compagny');
                $row->model = $form->getValue('model');
                $row->serial_number = $form->getValue('serial_number');
                $row->mac_address = $form->getValue('mac_address');
                $row->position = $form->getValue('position');
                $row->power_supply_position = $form->getValue('power_supply_position');

                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'ROUTER', 'UPDATE', $row->toArray(), $oldValue);

                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
}
 }
