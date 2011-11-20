<?php

class EssaiController extends Zend_Controller_Action
{
    public function preDispatch()
    {

    }

    public function indexAction()
    {
        
        //LDAP TEST

/*
        $options = array(
            'host'              => 'gestion.zapquebec.org',
            'username'          => 'CN=admin,DC=zapquebec,DC=org',
            'password'          => 'qwedc',
            'bindRequiresDn'    => true,
            'accountDomainName' => 'zapquebec.org',
            'baseDn'            => 'OU=People,DC=zapquebec,DC=org',);

        $ldap = new Zend_Ldap($options);
        $acctname = $ldap->getCanonicalAccountName('fsheedy',
            Zend_Ldap::ACCTNAME_FORM_DN);
        
        $this->view->acctname = $acctname;
        */
        
    }
}

