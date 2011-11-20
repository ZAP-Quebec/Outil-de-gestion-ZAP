<?php

class ZAP_Form_Invoices extends Zend_Form
{

    protected $_pre_id_customer = NULL;
    
    protected $_version = 'standard';
    /**
     * Décorateur par défaut
     * @var array
     */
    protected $_defaultDecorator = array(
        array('ViewHelper'),
        array('Description', array('tag' => 'span', 'class' => 'description')),
        array('Errors'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row')),
    );
    
    /**
     * Décorateur flottant à gauche (largeur 50 %)
     * @var array
     */
    protected $_floatLeftDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row left')),
    );
    
        protected $_hiddenDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'hidden')),
    );
    
    /**
     * Décorateur flottant à droite (largeur 50 %)
     * @var array
     */
    protected $_floatRightDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row right')),
    );
    
    /**
     * Décorateur avec label en style inline
     * (utile pour les cases à cocher)
     * @var array
     */
    protected $_inlineDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row inline')),
    );
    
    public function setVersion($version) {
      $this->_version = $version;
    }
    
    public function setIdCustomer($id_customer) {
      $this->_pre_id_customer = $id_customer;
    }
    
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'utf-8');
        
        $this->addElement('hidden', 'id', array(
        ));
        
        // Status field
        if ($this->_version == "add") {
          $this->addElement('hidden', 'status', array(
          ));
        } else {
          /*$this->addElement('text', 'status', array(
              'label'      => "État:",
              'required'   => true,
              'filters'    => array('StringTrim')
          ));*/
          
          $this->addElement('select', 'status', array(
            'label'        => "État:",
            'multiOptions' => array('Ébauche' => 'Ébauche', 'Annulée' => 'Annulée', 'Soumission' => 'Soumission', 'En attente' => 'En attente', 'Chèque' => 'Chèque', 'PayPal' => 'PayPal', 'Gracieuseté' => 'Gracieuseté'),
            'required'     => true,
            'filters'      => array('StringTrim')));
        }
        $customers = new ZAP_Model_Customers();
        $customersList = $customers->getCustomersName();
        $this->addElement('select', 'id_customer', array(
            'label'        => "Client:",
            'value'        => $this->_pre_id_customer,
            'multiOptions' => $customersList,
            'required'   => true,
            'filters'      => array('StringTrim')));
        
                // Add an email element
        $this->addElement('text', 'date', array(
            'label'      => "Date:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        

        $this->addElement('textarea', 'note', array(
            'label'      => "Note (sera inscrite sur la facture):",
            'required'   => false,
            'filters'    => array('StringTrim')
        ));




                    /**
     * Decorators
     */
    $this->clearDecorators();

    $this->addDecorator('FormElements')
         ->addDecorator('HtmlTag', array('tag' => '
<ul>', 'class' => 'form', 'id' => 'formtest'))
         ->addDecorator('Form');

    $this->setElementDecorators($this->_defaultDecorator);
    
                    // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => '',
        ));

    $this->getElement('submit')->setDecorators($this->_hiddenDecorator);

    /*$this->getElement('idCustomer')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('status')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('contact_firstname')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('contact_position')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('dateCreation')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('type')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('address')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('city')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('postalcode')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('province')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('phone_personal')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('phone_office')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('phone_cell')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('fax')->setDecorators($this->_floatRightDecorator);*/
    
    //$this->getElement('newsletter')->setDecorators($this->_inlineDecorator);


    return $this;
    }

}