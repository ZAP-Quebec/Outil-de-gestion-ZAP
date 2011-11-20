<?php

class ZAP_Form_Moijezap extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
        $this->addElement('text', 'nom', array(
            'label'      => "Nom de l'endroit:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));

        // Add an email element
        $this->addElement('select', 'active', array(
            'label'      => "État",
	    'multiOptions' => array(0 => 'Proposition', 1 => 'ZAP en service')
        ));

        // And finally add some CSRF protection
        $this->addElement('hidden', 'latitude', array(
        ));

        // And finally add some CSRF protection
        $this->addElement('hidden', 'longitude', array(
        ));

        // And finally add some CSRF protection
        $this->addElement('hidden', 'id', array(
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