<?php

class ZAP_Form_Customers extends Zend_Form {

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
    
        protected $_nameDecorator = array(
        array('ViewHelper'),
        array('Errors'),
        array('Description'),
        array('Label', array('requiredSuffix' => ' <span class="required">*</span>', 'escape' => false)),
        array('HtmlTag', array('tag' => 'li', 'class' => 'client_name')),
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
    
    public function init() {
        // Form Configuration
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'utf-8');

        // Elements
        $this->addElement('select', 'status', array(
            'label'      => "État",
            'multiOptions' => array('', 'Succès' , 'Échec')));

        $this->addElement('select', 'type', array(
            'label'      => "Type",
            'required'   => true,
            'multiOptions' => array('Entreprise', 'Personne' )));

        $this->addElement('text', 'name', array(
            'label'      => "Nom de l'endroit",
            'required'   => true));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'contact_firstname', array(
            'label'      => "Prénom",
            'required'   => true));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'contact_position', array(
            'label'      => "Occupation",
            'required'   => true));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'contact_lastname', array(
            'label'      => "Nom",
            'required'   => true));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'address', array(
            'label'      => "Adresse"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'city', array(
            'label'      => "Ville"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'postalcode', array(
            'label'      => "Code postal"));
            //'filters'    => array('StringTrim')));

       $this->addElement('select', 'province', array(
            'label'      => "Province",
            'multiOptions' => array('Québec',
                                    'Alberta',
                                    'Colombie-Britannique',
                                    'Île-du-Prince-Édouard',
                                    'Manitoba',
                                    'Nouveau-Brunswick',
                                    'Nouvelle-Écosse',
                                    'Nunavut',
                                    'Ontario',
                                    'Saskatchewan',
                                    'Terre-Neuve-et-Labrador',
                                    'Territoires du Nord-Ouest',
                                    'Yukon')));

        $this->addElement('text', 'phone_personal', array(
            'label'      => "Téléphone personnel"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'phone_office', array(
            'label'      => "Téléphone bureau"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'phone_cell', array(
            'label'      => "Cellulaire"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'fax', array(
            'label'      => "Télécopieur"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'email', array(
            'label'      => "Courriel"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'url', array(
            'label'      => "Site web"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'contract_date', array(
            'label'      => "Date du contrat"));
            //'filters'    => array('StringTrim')));

        $this->addElement('text', 'next_follow_date', array(
            'label'      => "Prochaine date de suivi"));
            //'filters'    => array('StringTrim')));

        $this->addElement('textarea', 'note', array(
            'label'      => "Note"));
            //'filters'    => array('StringTrim')));

        // Submit and CSRF
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => '',));

        // And finally add some CSRF protection
        /*$this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));*/

        //Decorators

        $this->clearDecorators();

        $this->addDecorator('FormElements')
             ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form', 'id' => 'formtest'))
             ->addDecorator('Form');

        $this->setElementDecorators($this->_defaultDecorator);

        $this->getElement('status')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('type')->setDecorators($this->_floatRightDecorator);

        $this->getElement('name')->setDecorators($this->_nameDecorator);
        $this->getElement('contact_firstname')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('contact_position')->setDecorators($this->_floatRightDecorator);

        $this->getElement('address')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('city')->setDecorators($this->_floatRightDecorator);

        $this->getElement('postalcode')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('province')->setDecorators($this->_floatRightDecorator);

        $this->getElement('phone_personal')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('phone_office')->setDecorators($this->_floatRightDecorator);

        $this->getElement('phone_cell')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('fax')->setDecorators($this->_floatRightDecorator);

        $this->getElement('email')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('url')->setDecorators($this->_floatRightDecorator);

        $this->getElement('contract_date')->setDecorators($this->_floatLeftDecorator);
        $this->getElement('next_follow_date')->setDecorators($this->_floatRightDecorator);

        //$this->getElement('csrf')->setDecorators($this->_hiddenDecorator);
        $this->getElement('submit')->setDecorators($this->_hiddenDecorator);

        return $this;
    }
}