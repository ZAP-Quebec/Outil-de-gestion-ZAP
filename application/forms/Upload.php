<?php

class ZAP_Form_Upload extends Zend_Form {

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

    public function init() {
      
      $translate = new Zend_Translate('tmx',APPLICATION_PATH .'/languages/french.tmx','fr');
      /*$translate = new Zend_Translate(
          'array',
          array(Zend_Validate_StringLength::TOO_SHORT => 'L\'extension du fichier \'%value%\' n\'est pas valide.'),
          'fr'
      );*/

      //die(APPLICATION_PATH);
      Zend_Registry::set('Zend_Translate', $translate);
      //Zend_Validate_Abstract::setDefaultTranslator($translate);


        // Set the method for the display form to POST
        $this->setMethod('post');

        $this->setName('upload');
        $this->setAttrib('enctype', 'multipart/form-data');

        /*$description = new Zend_Form_Element_Text('description');
        $description->setLabel('Description')
                  ->setRequired(true)
                  ->addValidator('NotEmpty');*/

        $file = new Zend_Form_Element_File('file');
        $file->setLabel('Fichier:')
             ->setDestination('/var/www/demo.gestion.zapquebec.org/data/node/')
             ->setRequired(true)
             ->addValidator('Count', false, 1)
             ->addValidator('Size', false, 20971520)
             ->setMaxFileSize(20971520)
             ->addValidator('Extension', false, 'jpg,png,gif,doc,docx,ppt,pptx,pdf,zip,bin,cfg,odt');


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('');

        $this->addElements(array($file, $submit));

    }
}