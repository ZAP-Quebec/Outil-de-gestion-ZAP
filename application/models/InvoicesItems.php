<?php

class ZAP_Model_InvoicesItems {
    // Champs
    protected $_id;
    protected $_category;
    protected $_unit_cost;
    protected $_description;
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
            $this->setMapper(new ZAP_Model_InvoicesItemsMapper());
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

    public function setCategory($text) {
        $this->_category = (string) $text;
        return $this;
    }

    public function getCategory() {
        return $this->_category;
    }

    public function setUnit_cost($text) {
        $this->_unit_cost = (string) $text;
        return $this;
    }

    public function getUnit_cost() {
        return $this->_unit_cost;
    }

    public function setDescription($text) {
        $this->_description = (string) $text;
        return $this;
    }

    public function getDescription() {
        return $this->_description;
    }

    // Fonctions specifiques
    public function getInvoiceItem($id) {
        return $this->getMapper()->getInvoiceItem($id);
    }

    public function getItemsName() {
        return $this->getMapper()->getItemsName();
    }

    /*public function getUser($id) {
        $result = $this->getMapper()->getUser($id);
        return $result;
    }*/
}
