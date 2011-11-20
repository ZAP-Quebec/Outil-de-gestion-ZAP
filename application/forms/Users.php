<?php

class ZAP_Form_Users extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        //$this->setAttrib('accept-charset', 'utf-8');

        // Add an email element
        $this->addElement('text', 'firstname', array(
            'label'      => "Prénom:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
                // And finally add some CSRF protection
        $this->addElement('hidden', 'id', array(
        ));
        
                // Add an email element
        $this->addElement('text', 'lastname', array(
            'label'      => "Nom:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
            // Add an email element
        $this->addElement('select', 'status', array(
            'label'      => "État",
            'multiOptions' => array('allowed' => 'Autorisé', 'expired' => 'Expiré')
        ));
        
                // Add an email element
        $this->addElement('text', 'title', array(
            'label'      => "Fonction:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
        // And finally add some CSRF protection
        $this->addElement('hidden', 'id_user', array(
        ));
      
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Modifier',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}