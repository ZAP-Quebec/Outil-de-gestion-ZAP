<?php

class AuthentificationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function preDispatch()
    {
	if (Zend_Auth::getInstance()->hasIdentity()) {
	    if ('logout' != $this->getRequest()->getActionName()) {
		$this->_helper->redirector('index', 'index');
	    }
	} else {
	    // If they aren’t, they can’t logout, so that action should
	    // redirect to the login form
	    if ('logout' == $this->getRequest()->getActionName()) {
        $this->_helper->redirector('index');
	    }
	}
    }

    public function indexAction() {
	$this->_helper->redirector('login', 'authentification');
    }

    public function noaccessAction() {
    }
    

    
    public function testAction() {
    sleep(2);
        $this->_helper->viewRenderer->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
        $request = $this->getRequest();
        $form = new ZAP_Form_Login();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                // authentification
                $return['error'] = false;
                $return['msg'] = 'authentification';
            } else {
                // formulaire non valide
                $return['error'] = true;
                $return['msg'] = "Tapez votre nom d'utilisateur et mot de passe.";
            }
        } else {
            // formulaire sans post
            $return['error'] = true;
            $return['msg'] = 'AJ01-No data';
        }
        
        echo Zend_Json_Encoder::encode($return);
    }

    public function loginAction() {
        $request = $this->getRequest();
        $form = new ZAP_Form_Login();

        $this->view->form = $form;
        $this->_helper->layout->setLayout('authentification');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $values = $form->getValues();

                // Encrypt password
                $password =base64_encode(pack("H*", md5(utf8_decode($values['password']))));

                // trouver le id du user
                $idUser = ZAP_Model_UsersWifidog::getId($values['username']);

                // valider si le user est dans la BD gestion
                $users = new ZAP_Model_Users();

                if ($users->isAllowed($idUser) == TRUE) {
                    // Authentification configuration
                    Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
                    $dbAdapter = Zend_Registry::get('db1');
                    $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                    $authAdapter->setTableName('users');
                    $authAdapter->setIdentityColumn('username');
                    $authAdapter->setCredentialColumn('pass');

                    // Authentification variables
                    $authAdapter->setIdentity($values['username']);
                    $authAdapter->setCredential($password);

                    // Authentification
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);

                    if ($result->isValid()) {
                        $data = $authAdapter->getResultRowObject(null, 'pass');
                        $auth->getStorage()->write($data);


                        $data2 = Zend_Auth::getInstance()->getStorage();
                        $userData = $data2->read();
                        $userInformation = new ZAP_Model_Users($users->getUser($idUser));
                        $userData->id_user = $userInformation->getId();
                        $userData->firstname = $userInformation->getFirstname();
                        $userData->lastname = $userInformation->getLastname();
                        $userData->status = $userInformation->getStatus();
                        $userData->title = $userInformation->getTitle();
                        $userData->longitude = $userInformation->getLongitude();
                        $userData->latitude = $userInformation->getLatitude();
                        $userData->phone = $userInformation->getPhone();
                        $userData->mobile = $userInformation->getMobile();

                        // Get groups
                        $userGroups = array();
                        $usersRowset = new ZAP_Model_DbTable_Users();
                        $user = $usersRowset->find($idUser)->current();
                        $groups = $user->findManyToManyRowset('ZAP_Model_DbTable_Groups', 'ZAP_Model_DbTable_Privileges');

                        foreach ($groups as $group)
                        {
                            $userGroups[]= $group->name;
                        }

                        $userData->groups = $userGroups;

                        $auth->getStorage()->write($userData);

                        $log = new ZAP_Model_Log();
                        $log->add($data->user_id, 'AUTHENTIFICATION', 'LOGIN');

                        return $this->_helper->redirector('index');
                    } else {
                        //die('mauvais mot de passe');
                    }
                } else {
                    // access interdit
                    //die('usager non autorise');
                }
            } else {
                //die('formulaire non valide');
            }
        }
    }

    public function logoutAction()
    {
	Zend_Auth::getInstance()->clearIdentity();
	$this->_helper->redirector('login', 'authentification'); // Retournez à la page de login
    }
}
