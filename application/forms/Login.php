<?php

class ZAP_Form_Login extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setName('loginform');
        //$this->setMethod('post');
        
        $this->setDecorators(array(
               'FormElements',
               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
               'Form'
       ));


        // Add an email element
        $this->addElement('text', 'username', array(
            'label'      => "Nom d'utilisateur:",
            'required'   => true,
            'filters'    => array('StringTrim'),
        ));
        
        // Add an email element
        $this->addElement('password', 'password', array(
            'label'      => "Mot de passe:",
            'required'   => true,
            'filters'    => array('StringTrim'),
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => '',
        ));

        // And finally add some CSRF protection
        //$this->addElement('hash', 'csrf', array(
        //    'ignore' => true,
        //));
    }
}
