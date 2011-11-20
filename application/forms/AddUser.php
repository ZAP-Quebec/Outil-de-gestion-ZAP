<?php

class ZAP_Form_AddUser extends Zend_Form {
    public function init() {
        $this->setMethod('post');

        $this->addElement('text', 'firstname', array(
            'label'      => "Prénom:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));

        $this->addElement('text', 'lastname', array(
            'label'      => "Nom:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));

        $this->addElement('text', 'email', array(
            'label'      => "Courriel:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => ''
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}