<?php

class ZAP_Model_InvoicesLines {
    // Champs
    protected $_id;
    protected $_id_invoice;
    protected $_description;
    protected $_note;
    protected $_number;
    protected $_unit_price;
    protected $_order;
    protected $_mapper;

    // Fonctions generales
    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid requests property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid requests property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setMapper($mapper) {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper() {
        if (null === $this->_mapper) {
            $this->setMapper(new ZAP_Model_InvoicesLinesMapper());
        }
        return $this->_mapper;
    }

    public function save() {
        $this->getMapper()->save($this);
    }

    public function update($id) {
        $this->getMapper()->update($id, $this);
    }

    public function find($id) {
        $this->getMapper()->find($id, $this);
        return $this;
    }

    function delete($id) {
        $this->getMapper()->delete($id);
    }

    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }

    // Fonctions champs
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId_invoice($text) {
        $this->_id_invoice = (string) $text;
        return $this;
    }

    public function getId_invoice() {
        return $this->_id_invoice;
    }

    public function setDescription($text) {
        $this->_description = (string) $text;
        return $this;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function setOrder($text) {
        $this->_order = (string) $text;
        return $this;
    }

    public function getOrder() {
        return $this->_order;
    }

    public function setNumber($text) {
        $this->_number = (string) $text;
        return $this;
    }

    public function getNumber() {
        return $this->_number;
    }
    
    public function setUnit_price($text) {
        $unitPrice = (string) $text;
        $unitPrice = str_replace(',', '.', $unitPrice);
        $this->_unit_price = $unitPrice;
        return $this;
    }

    public function getUnit_price() {
        return $this->_unit_price;
    }

    public function setNote($text) {
        $this->_note = (string) $text;
        return $this;
    }

    public function getNote() {
        return $this->_note;
    }

    // Fonctions specifiques
    public function fetchByInvoice($id_invoice) {
        return $this->getMapper()->fetchByInvoice($id_invoice);
    }
    
    public function fetchByInvoiceDesc($id_invoice) {
        return $this->getMapper()->fetchByInvoiceDesc($id_invoice);
    }

    public function getInvoiceLines($id_invoice) {
        return $this->getMapper()->getInvoiceLines($id_invoice);
    }

    public function fetchById($id) {
        return $this->getMapper()->fetchById($id);
    }

    /*public function getUser($id) {
        $result = $this->getMapper()->getUser($id);
        return $result;
    }*/
}
