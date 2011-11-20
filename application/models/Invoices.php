<?php

class ZAP_Model_Invoices {
    // Champs
    protected $_id;
    protected $_id_customer;
    protected $_date;
    protected $_status;
    protected $_note;
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
            $this->setMapper(new ZAP_Model_InvoicesMapper());
        }
        return $this->_mapper;
    }

    public function save() {
        $result = $this->getMapper()->save($this);
        return $result;
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
    
    public function fetchByCustomer($id) {
        return $this->getMapper()->fetchByCustomer($id);
    }

    // Fonctions champs
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId_customer($text) {
        $this->_id_customer = (string) $text;
        return $this;
    }

    public function getId_customer() {
        return $this->_id_customer;
    }

    public function setDate($text) {
        $this->_date = (string) $text;
        return $this;
    }

    public function getDate() {
        return $this->_date;
    }
    
    public function setStatus($text) {
        $this->_status = (string) $text;
        return $this;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setNote($text) {
        $this->_note = (string) $text;
        return $this;
    }

    public function getNote() {
        return $this->_note;
    }

    // Fonctions specifiques

    public function getInvoice($id) {
        return $this->getMapper()->getInvoice($id);
    }

    public static function translateStatus($status) {
        switch($status) {
            case 'NEW':
                $result = 'Nouvelle';
                break;
            case 'ASSIGNED':
                $result = 'Assignée';
                break;
            case 'CLOSED':
                $result = 'Fermée';
                break;
            default:
                $result = 'Inconnu';
                break;
        }

        return $result;
    }

    /*public function getUser($id) {
        $result = $this->getMapper()->getUser($id);
        return $result;
    }*/
}
