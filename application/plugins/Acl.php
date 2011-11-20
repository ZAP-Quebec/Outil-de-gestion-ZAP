<?php
/**
 * Fichier acl
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

class ZAP_Plugin_Acl extends Zend_Acl
{
    /**
     * __construct
     *
     */
    public function __construct() {
        // Roles permanents
        $this->addRole(new Zend_Acl_Role('sysadmin'));
        $this->addRole(new Zend_Acl_Role('developer'));
        $this->addRole(new Zend_Acl_Role('ca'));
        $this->addRole(new Zend_Acl_Role('employee'));
        $this->addRole(new Zend_Acl_Role('volunteer'));

        // Role temporaire
        $this->addRole(new Zend_Acl_Role('alpha'));


        // Ressources
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('authentification'));
        $this->add(new Zend_Acl_Resource('moijezap'));
        $this->add(new Zend_Acl_Resource('invoice'));
        $this->add(new Zend_Acl_Resource('invoiceline'));
        $this->add(new Zend_Acl_Resource('user'));
        $this->add(new Zend_Acl_Resource('request'));
        $this->add(new Zend_Acl_Resource('comment'));
        $this->add(new Zend_Acl_Resource('router'));
        $this->add(new Zend_Acl_Resource('customer'));
        $this->add(new Zend_Acl_Resource('node'));
        $this->add(new Zend_Acl_Resource('essai'));

        $this->add(new Zend_Acl_Resource('admin-user-management'));


        $this->add(new Zend_Acl_Resource('filemanager'));

        $this->add(new Zend_Acl_Resource('alpha'));
        $this->add(new Zend_Acl_Resource('alpha-moijezap'));
        $this->add(new Zend_Acl_Resource('alpha-request'));
        $this->add(new Zend_Acl_Resource('alpha-node'));
        $this->add(new Zend_Acl_Resource('alpha-user-modification'));
        
        //zend ressource
        $this->add(new Zend_Acl_Resource('error'));


        // === USER ===
        // Module Index
        $this->allow('volunteer', 'index');

        $this->allow(null, 'authentification');
        // Module User
       /* Zend_Loader::loadClass('OnlyCreatorAssertion');
        $this->allow('user', 'user', null, new OnlyCreatorAssertion());*/

        // Request - comment
        $this->allow('volunteer', 'request', 'view-comment');

        // === FIN USER ===
        // Moderator
        $this->allow('volunteer', 'index');
        $this->allow('volunteer', null, array('view', 'modify'));
        $this->allow('volunteer', 'node');
        $this->allow('volunteer', 'comment');
        
        
        // ca
        $this->allow('ca', 'index');
        $this->allow('ca', 'filemanager');
        $this->allow('ca', 'node');
        $this->allow('ca', 'alpha-node');
        $this->allow('ca', 'request');
        $this->allow('ca', 'comment');
        $this->deny('ca', 'comment', 'delete');
        $this->allow('ca', 'alpha-request');
        $this->allow('ca', 'user', 'add');
        $this->allow('ca', 'user', 'index');
        $this->allow('ca', 'customer');
        $this->allow('ca', 'invoice');
        $this->allow('ca', 'invoiceline');
       /* $this->allow('ca', 'moijezap');
        $this->allow('ca', 'customer');
        $this->allow('ca', 'invoice');*/
        
        // alpha tester
        //$this->allow('administrator', 'alpha', 'alpha-user-modification');
        
        // Administrator
        /*$this->allow('sysadmin');*/
        
        $this->allow('sysadmin', 'index');
        $this->allow('sysadmin', 'filemanager');
        $this->allow('sysadmin', 'node');
        $this->allow('sysadmin', 'alpha-node');
        $this->allow('sysadmin', 'request');
        $this->allow('sysadmin', 'comment');
        $this->deny('sysadmin', 'comment', 'delete');
        $this->allow('sysadmin', 'alpha-request');
        $this->allow('sysadmin', 'user', 'add');
        $this->allow('sysadmin', 'customer');
        $this->allow('sysadmin', 'user', 'index');
        $this->allow('sysadmin', 'invoice');
        $this->allow('sysadmin', 'invoiceline');
        
        $this->allow('sysadmin', 'index');
        $this->allow('sysadmin', null, array('view', 'modify'));
        $this->allow('sysadmin', 'node');
        $this->allow('sysadmin', 'comment');
        
        
        // All
        $this->allow(null, 'error');
        
        
        
        
        //$this->allow('sysadmin', 'user');
        //$this->allow('sysadmin', 'user', 'index');
        /*
        $this->allow('sysadmin', 'index');
        $this->allow('sysadmin', 'filemanager');
        $this->allow('sysadmin', 'node');
        $this->allow('sysadmin', 'alpha-node');
        $this->allow('sysadmin', 'request');
        $this->allow('sysadmin', 'comment');
        $this->deny('sysadmin', 'comment', 'delete');
        $this->allow('sysadmin', 'alpha-request');
        $this->allow('sysadmin', 'alpha-moijezap');
        $this->allow('sysadmin', 'user');
        $this->allow('sysadmin', 'user', 'groupManagement');
        $this->allow('sysadmin', 'admin-user-management');
        $this->allow('sysadmin', 'alpha');
        
*/

    }
}