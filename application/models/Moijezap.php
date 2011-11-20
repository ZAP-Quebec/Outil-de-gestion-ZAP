<?php

class ZAP_Model_Moijezap
{
    protected $_id;
    protected $_latitude;
    protected $_longitude;
    protected $_nom;
    protected $_active;
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
            throw new Exception('Invalid moijezap property1');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid moijezap property2');
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

    public function setLatitude($text)
    {
        $this->_latitude = (string) $text;
        return $this;
    }

    public function getLatitude()
    {
        return $this->_latitude;
    }

    public function setLongitude($text)
    {
        $this->_longitude = (string) $text;
        return $this;
    }

    public function getLongitude()
    {
        return $this->_longitude;
    }

    public function setNom($text)
    {
        $this->_nom = (string) $text;
        return $this;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function setActive($text)
    {
        $this->_active = (string) $text;
        return $this;
    }

    public function getActive()
    {
        return $this->_active;
    }

    /*public function setCreated($ts)
    {
        $this->_created = $ts;
        return $this;
    }

    public function getCreated()
    {
        return $this->_created;
    }*/

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new ZAP_Model_MoijezapMapper());
        }
        return $this->_mapper;
    }

    public function save()
    {
        $this->getMapper()->save($this);
    }

    public function update($id)
    {
        $this->getMapper()->update($id, $this);
    }

    public function find($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }
    public function getPlace($id)
    {
        $result = $this->getMapper()->getPlace($id);
        return $result;
    }
	
    function delete($id)
    {
	$this->getMapper()->delete($id);
    }

    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
}
