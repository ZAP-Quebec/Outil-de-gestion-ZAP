<?php
/**
 * Upload Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Upload Controller Class
 *
 * @version    1.0
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class UploadController extends Zend_Controller_Action {
    /**
     * Init
     */
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();

    }

        public function preDispatch()
    {
        $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()) {
        $this->username = $auth->getIdentity()->username;
    } else {
        $this->_helper->redirector('login', 'authentification');
    }
    }

    public function indexAction()
    {

        $form = new ZAP_Form_Upload();

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {

                // success - do something with the uploaded file
                $uploadedData = $form->getValues();
                $form->file->addFilter('Rename', '/home/fsheedy/' . '/data/uploads/'.'file212');
                    if (!$form->file->receive()) {
        print_r($form->file->getMessages());
    }

                
                $fullFilePath = $form->file->getFileName();

                Zend_Debug::dump($uploadedData, '$uploadedData');
                Zend_Debug::dump($fullFilePath, '$fullFilePath');

                echo "done";
                exit;

            } else {
                $form->populate($formData);
            }
        }

        $this->view->form = $form;

    }

}
