<?php

class ZAP_Model_Users {
    // Champs
    protected $_id;
    protected $_status;
    protected $_role;
    protected $_longitude;
    protected $_latitude;
    protected $_phone;
    protected $_mobile;
    protected $_firstname;
    protected $_lastname;
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
            throw new Exception('Invalid users property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid users property');
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
            $this->setMapper(new ZAP_Model_UsersMapper());
        }
        return $this->_mapper;
    }

    public function save($insert = false) {
        $this->getMapper()->save($this, $insert);
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

    public function fetchAllWithEmail() {
        return $this->getMapper()->fetchAllWithEmail();
    }

    // Fonctions champs
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setStatus($text) {
        $this->_status = (string) $text;
        return $this;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setRole($text) {
        $this->_role = (string) $text;
        return $this;
    }

    public function getRole() {
        return $this->_role;
    }

    public function setLongitude($text) {
        $this->_longitude = (string) $text;
        return $this;
    }

    public function getLongitude() {
        return $this->_longitude;
    }

    public function setLatitude($text) {
        $this->_latitude = (string) $text;
        return $this;
    }

    public function getLatitude() {
        return $this->_latitude;
    }

    public function setPhone($text) {
        $this->_phone = (string) $text;
        return $this;
    }

    public function getPhone() {
        return $this->_phone;
    }

    public function setMobile($text) {
        $this->_mobile = (string) $text;
        return $this;
    }

    public function getMobile() {
        return $this->_mobile;
    }

    public function setFirstname($text) {
        $this->_firstname = (string) $text;
        return $this;
    }

    public function getFirstname() {
        return $this->_firstname;
    }

    public function setLastname($text) {
        $this->_lastname = (string) $text;
        return $this;
    }

    public function getLastname() {
        return $this->_lastname;
    }

    // Fonctions specifiques
    public function isAllowed($id) {
        return $this->getMapper()->isAllowed($id);
    }

    public function getUser($id) {
        $result = $this->getMapper()->getUser($id);
        return $result;
    }

    public function getUserName($id) {
        $result = $this->getMapper()->getUserName($id);
        return $result;
    }

    public function getUsersName() {
        $result = $this->getMapper()->getUsersName();
        return $result;
    }
}
