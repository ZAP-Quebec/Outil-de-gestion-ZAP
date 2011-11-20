<?php

class ZAP_Model_Requests {
    // Champs
    protected $_id;
    protected $_id_node;
    protected $_id_user;
    protected $_id_user_assigned;
    protected $_date_open;
    protected $_date_close;
    protected $_status;
    protected $_summary;
    protected $_priority;
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
            $this->setMapper(new ZAP_Model_RequestsMapper());
        }
        return $this->_mapper;
    }

    public function save() {
        $id = $this->getMapper()->save($this);
        return $id;
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

    public function setId_node($text) {
        $this->_id_node = (string) $text;
        return $this;
    }

    public function getId_node() {
        return $this->_id_node;
    }

    public function setId_user($text) {
        $this->_id_user = (string) $text;
        return $this;
    }

    public function getId_user() {
        return $this->_id_user;
    }

    public function setId_user_assigned($text) {
        $this->_id_user_assigned = (string) $text;
        return $this;
    }

    public function getId_user_assigned() {
        return $this->_id_user_assigned;
    }

    public function setDate_open($text) {
        $this->_date_open = (string) $text;
        return $this;
    }

    public function getDate_open() {
        return $this->_date_open;
    }

    public function setDate_close($text) {
        $this->_date_close = (string) $text;
        return $this;
    }

    public function getDate_close() {
        return $this->_date_close;
    }

    public function setStatus($text) {
        $this->_status = (string) $text;
        return $this;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setSummary($text) {
        $this->_summary = (string) $text;
        return $this;
    }

    public function getSummary() {
        return $this->_summary;
    }

    public function setPriority($text) {
        $this->_priority = (string) $text;
        return $this;
    }

    public function getPriority() {
        return $this->_priority;
    }

    public function setDescription($text) {
        $this->_description = (string) $text;
        return $this;
    }

    public function getDescription() {
        return $this->_description;
    }

    // Fonctions specifiques
    public function fetchByUser($id) {
        return $this->getMapper()->fetchByUser($id);
    }

    public function getRequest($id) {
        $result = $this->getMapper()->getRequest($id);
        return $result;
    }

    public function getPriorityList() {
        $rowset = array('vhi' => 'Très haute',
                        'hi'  => 'Haute',
                        'nor' => 'Normale',
                        'lo'  => 'Basse',
                        'vlo' => 'Très basse');

        return $rowset;
    }

    /*public function getStatusList() {
        $rowset = array('NEW' => 'Nouvelle',
                        'ASSIGNED' => 'Assignée',
                        'CLOSED' => 'Fermée');

        return $rowset;
    }*/

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

}
