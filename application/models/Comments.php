<?php

class ZAP_Model_Comments {
    // Champs
    protected $_id;
    protected $_id_user;
    protected $_id_reference;
    protected $_module;
    protected $_date;
    protected $_time;
    protected $_status;
    protected $_comment;
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
            $this->setMapper(new ZAP_Model_CommentsMapper());
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

    public function setId_user($text) {
        $this->_id_user = (string) $text;
        return $this;
    }

    public function getId_user() {
        return $this->_id_user;
    }

    public function setId_reference($text) {
        $this->_id_reference = (string) $text;
        return $this;
    }

    public function getId_reference() {
        return $this->_id_reference;
    }

    public function setModule($text) {
        $this->_module = (string) $text;
        return $this;
    }

    public function getModule() {
        return $this->_module;
    }

    public function setDate($text) {
        $this->_date = (string) $text;
        return $this;
    }

    public function getDate() {
        return $this->_date;
    }
    
    public function setTime($time) {
        $this->_time = $time;
        return $this;
    }

    public function getTime() {
        return $this->_time;
    }
        public function setStatus($text) {
        $this->_status = (string) $text;
        return $this;
    }

    public function getStatus() {
        return $this->_status;
    }
        public function setComment($text) {
        $this->_comment = (string) $text;
        return $this;
    }

    public function getComment() {
        return $this->_comment;
    }

    // Fonctions specifiques

    public function fetchByRequest($id_request, $module = NULL) {
        return $this->getMapper()->fetchByRequest($id_request, $module);
    }

    public function fetchById($id) {
        return $this->getMapper()->fetchById($id);
    }

    /*public function getUser($id) {
        $result = $this->getMapper()->getUser($id);
        return $result;
    }*/
}
