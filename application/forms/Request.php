<?php

class ZAP_Form_Request extends Zend_Form
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
    protected $_floatFullDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row left')),
    );

    /**
     * Décorateur flottant à gauche (largeur 100 %)
     * @var array
     */
    protected $_floatLeftDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'row full')),
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

        $this->addElement('hidden', 'id', array(
            'filters'      => array('StringTrim')));
        
        $this->addElement('hidden', 'status', array(
            'filters'      => array('StringTrim')));

        $requests = new ZAP_Model_Requests();

        $this->addElement('text', 'summary', array(
            'label'        => "Sommaire:",
            'required'     => true,
            'filters'      => array('StringTrim')));
            

            

       $priorityList = $requests->getPriorityList();
       $this->addElement('select', 'priority', array(
            'label'        => "Priorité:",
            'multiOptions' => $priorityList,
            'value'        => 'nor',
            'required'     => true,
            'filters'      => array('StringTrim')));
            
            
        $nodes = new ZAP_Model_NodesWifidog();
        $nodesList = $nodes->getNodesName();
        $this->addElement('select', 'id_node', array(
            'label'        => "Point d'accès:",
            'multiOptions' => $nodesList,
            'filters'      => array('StringTrim')));
            
        $users = new ZAP_Model_Users();
        $usersList = $users->getUsersName();
        
               $this->addElement('text', 'date_open', array(
            'label'        => "Date d'ouverture:",
            'filters'      => array('StringTrim')));
            
        $this->addElement('select', 'id_user', array(
            'label'        => "Demandeur:",
            'multiOptions' => $usersList,
            'required'     => true,
            'filters'      => array('StringTrim')));
       $this->addElement('text', 'date_close', array(
            'label'        => "Date de fermeture:",
            'filters'      => array('StringTrim')));


        $this->addElement('select', 'id_user_assigned', array(
            'label'        => "Bénévole assigné:",
            'multiOptions' => $usersList,
            'filters'      => array('StringTrim')));

       $this->addElement('textarea', 'description', array(
            'label'        => "Description:",
            'required'     => true,
            'filters'      => array('StringTrim')));




        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => '',
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

    /*$this->getElement('id')->setDecorators($this->_hiddenDecorator);
    $this->getElement('status')->setDecorators($this->_hiddenDecorator);
    
    $this->getElement('summary')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('priority')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('id_node')->setDecorators($this->_floatFullDecorator);
   
    
    $this->getElement('date_open')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('id_user')->setDecorators($this->_floatRightDecorator);
    
    $this->getElement('date_close')->setDecorators($this->_floatLeftDecorator);
    $this->getElement('id_user_assigned')->setDecorators($this->_floatRightDecorator);
    */
    //$this->getElement('newsletter')->setDecorators($this->_inlineDecorator);
    //$this->getElement('csrf')->setDecorators($this->_hiddenDecorator);
    $this->getElement('submit')->setDecorators($this->_hiddenDecorator);
    //$this->getElement('submit')->setDecorators($this->_submitDecorator);

    return $this;
    }
}
