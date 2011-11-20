<?php

class ZAP_Model_NodesWifidog
{
    protected $_node_id;
    protected $_name;
    protected $_node_deployment_status;
    protected $_mapper;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid nodeswifidog property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid nodeswifidog property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setNode_id($id)
    {
        $this->_node_id = (string) $id;
        return $this;
    }

    public function getNode_Id()
    {
        return $this->_node_id;
    }

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName()
    {
       return $this->_name;
    }

    public function setNode_deployment_status($node_deployment_status)
    {
        $this->_node_deployment_status = $node_deployment_status;
        return $this;
    }

    public function getNode_deployment_status() {
	$node_deployment_status = $this->_node_deployment_status;
        switch($node_deployment_status) {
            case 'DEPLOYED':
                $result= 'Déployé';
                break;
            case 'IN_PLANNING':
                $result= 'En planification';
                break;
            case 'IN_TESTING':
                $result= 'En essai';
                break;
            case 'NON_WIFIDOG_NODE':
                $result= 'Sympathisant';
                break;
            case 'PERMANENTLY_CLOSED':
                $result= 'Fermeture permanente';
                break;
            case 'TEMPORARILY_CLOSED':
                $result= 'Fermeture temporaire';
                break;
            default:
                $result = 'Inconnu';
                break;
        }
        
	return $result;
    }

    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }

    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new ZAP_Model_NodesWifidogMapper());
        }
        return $this->_mapper;
    }

    public function getNodesName() {
        return $this->getMapper()->getNodesName();
    }

    public function find($id) {
        $this->getMapper()->find($id, $this);
        return $this;
    }
}
