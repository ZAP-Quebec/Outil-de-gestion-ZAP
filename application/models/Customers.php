<?php

class ZAP_Model_Customers {
    // Champs
    protected $_id;
    protected $_date_creation;
    protected $_date_modified;
    protected $_name;
    protected $_type;
    protected $_contact_firstname;
    protected $_contact_lastname;
    protected $_contact_position;
    protected $_address;
    protected $_city;
    protected $_province;
    protected $_postalcode;
    protected $_phone_personal;
    protected $_phone_office;
    protected $_phone_cell;
    protected $_fax;
    protected $_email;
    protected $_url;
    protected $_contract_date;
    protected $_note;
    protected $_status;
    protected $_next_follow_date;
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
            $this->setMapper(new ZAP_Model_CustomersMapper());
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

    public function fetchAll($where = NULL) {
        return $this->getMapper()->fetchAll($where);
    }
    
    public function getNamebyId($id) {
        return $this->getMapper()->getNamebyId($id);
    }

    // Fonctions champs
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setDate_creation($text) {
        $this->_date_creation = (string) $text;
        return $this;
    }

    public function getDate_creation() {
        return $this->_date_creation;
    }

    public function setDate_modified($text) {
        $this->_date_modified = (string) $text;
        return $this;
    }

    public function getDate_modified() {
        return $this->_date_modified;
    }

    public function setName($text) {
        $this->_name = (string) $text;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function setType($text) {
        $this->_type = (string) $text;
        return $this;
    }

    public function getType() {
        return $this->_type;
    }

    public function setContact_firstname($text) {
        $this->_contact_firstname = (string) $text;
        return $this;
    }

    public function getContact_firstname() {
        return $this->_contact_firstname;
    }

    public function setContact_lastname($text) {
        $this->_contact_lastname = (string) $text;
        return $this;
    }

    public function getContact_lastname() {
        return $this->_contact_lastname;
    }

    public function setContact_position($text) {
        $this->_contact_position = (string) $text;
        return $this;
    }

    public function getContact_position() {
        return $this->_contact_position;
    }

    public function setAddress($text) {
        $this->_address = (string) $text;
        return $this;
    }

    public function getAddress() {
        return $this->_address;
    }

    public function setCity($text) {
        $this->_city = (string) $text;
        return $this;
    }

    public function getCity() {
        return $this->_city;
    }

    public function setProvince($text) {
        $this->_province = (string) $text;
        return $this;
    }

    public function getProvince() {
        return $this->_province;
    }

    public function setPostalcode($text) {
        $this->_postalcode = (string) $text;
        return $this;
    }

    public function getPostalcode() {
        return $this->_postalcode;
    }

    public function setPhone_personal($text) {
        $this->_phone_personal = (string) $text;
        return $this;
    }

    public function getPhone_personal() {
        return $this->_phone_personal;
    }

    public function setPhone_office($text) {
        $this->_phone_office = (string) $text;
        return $this;
    }

    public function getPhone_office() {
        return $this->_phone_office;
    }

    public function setPhone_cell($text) {
        $this->_phone_cell = (string) $text;
        return $this;
    }

    public function getPhone_cell() {
        return $this->_phone_cell;
    }

    public function setFax($text) {
        $this->_fax = (string) $text;
        return $this;
    }

    public function getFax() {
        return $this->_fax;
    }

    public function setEmail($text) {
        $this->_email = (string) $text;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setUrl($text) {
        $this->_url = (string) $text;
        return $this;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function setContract_date($text) {
        $this->_contract_date = (string) $text;
        return $this;
    }

    public function getContract_date() {
        return $this->_contract_date;
    }

    public function setNote($text) {
        $this->_note = (string) $text;
        return $this;
    }

    public function getNote() {
        return $this->_note;
    }

    public function setStatus($text) {
        $this->_status = (string) $text;
        return $this;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setNext_follow_date($text) {
        $this->_next_follow_date = (string) $text;
        return $this;
    }

    public function getNext_follow_date() {
        return $this->_next_follow_date;
    }

    // Fonctions specifiques

    /*public function isAllowed($id) {
        return $this->getMapper()->isAllowed($id);
    }*/

    public function getCustomer($id) {
        $result = $this->getMapper()->getCustomer($id);
        return $result;
    }

    public function getCustomersName() {
        $result = $this->getMapper()->getCustomersName();
        return $result;
    }
}
