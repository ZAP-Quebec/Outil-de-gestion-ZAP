<?php

class ZAP_Form_Node extends Zend_Form
{
    public function init()
    {
                // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'utf-8');
        
        $this->setName('request');

        $idNode = new Zend_Form_Element_Hidden('id_node');
        $images = new Zend_Form_Element_Hidden('images');
        $images->setRequired(false)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('Alnum');

        $contactAdministration = new Zend_Form_Element_Select('contact_administration');
        $contactAdministration->setLabel('Responsable administratif')
        ->setRequired(true)
        ->addMultiOptions(array("contact1", "contact2"))/*Contact::listOption()*/
        ->addFilter('StripTags')
        ->addFilter('StringTrim');

        $contactTechnical = new Zend_Form_Element_Select('contact_technical');
        $contactTechnical->setLabel('Responsable technique')
        ->setRequired(true)
        ->addMultiOptions(array("contact1", "contact2"))/*Contact::listOption()*/
        ->addFilter('StripTags')
        ->addFilter('StringTrim');

        $idRouter = new Zend_Form_Element_Select('id_router');
        $idRouter->setLabel("Routeur")
        ->setRequired(true)
        ->addMultiOptions(array("routeur1", "routeur2"))/*Router::listOption()*/
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('Alnum');

        $idAntenna = new Zend_Form_Element_Select('id_antenna');
        $idAntenna->setLabel("Antenne")
        ->setRequired(true)
        ->addMultiOptions(array("antenne1", "antenne2"))/*Antenna::listOption()*/
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('Alnum');

        $internetSupplierName = new Zend_Form_Element_Text('internet_supplier_name');
        $internetSupplierName->setLabel("Fournisseur internet")
        ->setRequired(false)
        ->addFilter('StripTags')
        ->addFilter('StringTrim');

        $internetModemModel = new Zend_Form_Element_Text('internet_modem_model');
        $internetModemModel->setLabel("Modem internet")
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim');

        /*$submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submit');*/
        


        $this->addElements(array($idNode, $images, $contactAdministration, $contactTechnical, $idRouter, $idAntenna, $internetSupplierName, $internetModemModel));
        
                        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => '',
        ));
    }
}