<?php

class ZAP_Form_Invoices2 extends Zend_Form
{

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
    
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'utf-8');
        
        //$this->addElement('hidden', 'id', array(
        //));
        
            $this->addElement('hidden', 'id', array(
      'value' => 1
    ));

        
                $this->addElement('text', 'status', array(
            'label'      => "État:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
        $customers = new ZAP_Model_Customers();
        $customersList = $customers->getCustomersName();
        $this->addElement('select', 'id_customer', array(
            'label'        => "Client:",
            'multiOptions' => $customersList,
            'filters'      => array('StringTrim')));
        
                // Add an email element
        $this->addElement('text', 'date', array(
            'label'      => "Date:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        

                                           // Add an email element
        $this->addElement('textarea', 'note', array(
            'label'      => "Note:",
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
            $this->addElement('button', 'addElement', array(
      'label' => 'Add',
      'order' => 91
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

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));

        $this->getElement('csrf')->setDecorators($this->_hiddenDecorator);
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