<?php
/**
 * Enter description here...
 *
 */
class Gestion_Controller_Plugin_Security extends Zend_Controller_Plugin_Abstract {
    
    private $_auth;
    private $_acl;

    /**
     * Constructeur : Initialise les variables privés d'Authentification et de gestion des ACL
     *
     * @param Zend_Auth::getInstance() $auth récupéré grâce à la méthode getInstance() de ZF
     */
    public function __construct() {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = new Gestion_Controller_Helper_Acl();
        Zend_Registry::set('acl', $this->_acl);
    }

    /**
     * Enter description here...
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        if ($this->_auth->hasIdentity()) {
            Zend_Registry::set('identity', $this->_auth->getIdentity());

            // Role
            $role = 'user'.$this->_auth->getIdentity()->role;

            // Ressource
            $resource = $request->getControllerName();

            if (!$this->_acl->has($resource)) {
                $resource = null;
            }

            // Privilege
            $privilege = $request->getActionName();
            
            // Request
            //Zend_Registry::set('current_request', $request);

            if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
                //exit('Acc&agrave; non autoris&eacute;<br /><br />Ne paniquez pas, test seulement.');
                //$request->setControllerName('authentification');
                //$request->setActionName('noaccess');
            }
        } else {
            $request->setControllerName('authentification');
            $request->setActionName('login');
        }
    }
}