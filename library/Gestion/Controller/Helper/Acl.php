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




/*
 * 
 * NOT USED!!
 */



class Gestion_Controller_Helper_Acl extends Zend_Acl
{
    /**
     * __construct
     *
     */
    public function __construct() {
        $this->addRole(new Zend_Acl_Role('user'));
        $this->addRole(new Zend_Acl_Role('moderator'));
        $this->addRole(new Zend_Acl_Role('administrator'));

        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('user'));
        $this->add(new Zend_Acl_Resource('request'));
        $this->add(new Zend_Acl_Resource('request-comment'));
        $this->add(new Zend_Acl_Resource('router'));
        $this->add(new Zend_Acl_Resource('contact'));
        $this->add(new Zend_Acl_Resource('node'));
        $this->add(new Zend_Acl_Resource('authentification'));

        // Module authentification (tous)
        $this->allow(null, 'authentification', 'noaccess');
        $this->allow(null, 'authentification', 'logout');
        $this->allow(null, 'authentification', 'login');

        // Module Index
        $this->allow('user', 'index');
        $this->allow('user', 'index', 'view');
        
        // Module User
        //Zend_Loader::loadClass('OnlyCreatorAssertion');
        //$this->allow('user', 'user', null, new OnlyCreatorAssertion());

        // Request - comment
        $this->allow('user', 'request', 'view-comment');

        // === FIN USER ===
        // Moderator

        
        // Administrator
        $this->allow('administrator');

        

        
        /*
        $tabMembreAllow = array('index', 'detail', 'rechercher');
        
        $this->allow('member', 'default');    
        $this->allow('member', 'structure',     $tabMembreAllow);    
        $this->allow('member', 'appart',         $tabMembreAllow);
        $this->allow('member', 'pretendant',    $tabMembreAllow);
        $this->allow('member', 'locataire',     $tabMembreAllow);
        $this->allow('member', 'location',        $tabMembreAllow);
        $this->allow('member', 'facture',         $tabMembreAllow);
        $this->allow('member', 'plainte',        $tabMembreAllow);
        $this->allow('member', 'reclamation',     $tabMembreAllow);
        $this->allow('member', 'quitance',        $tabMembreAllow);
        $this->allow('member', 'portal_user',    $tabMembreAllow);

        //-- Refuser --//
        $tabMembreDeny = array('supprimer', 'modifier','ajouter');
        
        $this->deny('member', 'structure',         $tabMembreDeny);    
        $this->deny('member', 'appart',         $tabMembreDeny);
        $this->deny('member', 'pretendant',     $tabMembreDeny);
        $this->deny('member', 'locataire',         $tabMembreDeny);
        $this->deny('member', 'location',         $tabMembreDeny);
        $this->deny('member', 'facture',         $tabMembreDeny);
        $this->deny('member', 'plainte',         $tabMembreDeny);
        $this->deny('member', 'reclamation',     $tabMembreDeny);
        $this->deny('member', 'quitance',         $tabMembreDeny);
        $this->deny('member', 'configuration');                            //-- Seul l'admin gère les utilisateurs
        $this->deny('member', 'user');                                    //-- seul l'admin gère les utilisateurs
        $this->deny('member', 'portal_user',     $tabMembreDeny);
*/

    }
}