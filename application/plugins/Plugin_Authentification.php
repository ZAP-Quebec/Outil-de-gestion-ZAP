<?php
/**
 * Fichier PluginAuth
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

class Plugin_Authentification extends Zend_Controller_Plugin_Abstract
{
    private $_auth;
    private $_acl;

    /**
     * Constructeur : Initialise les variables privés d'Authentification et de gestion des ACL
     *
     * @param Zend_Auth::getInstance() $auth récupéré grâce à la méthode getInstance() de ZF
     */
    public function __construct($auth, $acl)
    {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }

    /**
     * Est appelé en PreDispatch et décide pour chaque page visité si l'utilsiateur est identifié
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        // Authentification
        if ($this->_auth->hasIdentity()) {
            // Role
            $user = Zend_Auth::getInstance()->getIdentity();
            $role = $user->role;

            // Ressource
            $controller = $request->getControllerName();
            $resource = $controller;

            if (!$this->_acl->has($resource)) {
                $resource = null;
            }

            // Privilege
            $action = $request->getActionName();
            $privilege = $action;
            
            // Request
            Zend_Registry::set('current_request', $request);

            //-- Si l'accès à la ressource + priviliège est autorisé  est autorisé --//
            if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
                /*$module     = 'acl';
                $controller = 'index';
                $action     = 'forbiden';*/
                //setParams( array('kk' = 'kk'));
                exit('Acc&agrave; non autoris&eacute;<br /><br />Ne paniquez pas, test seulement.');
            }

            //-- redirection vers le module + controlleur + action en sortant du plugin --//
            $request->setControllerName($controller);
            $request->setActionName($action);
        } else {
            $request->setControllerName('authentification');
            $request->setActionName('login');
        }
    }
}