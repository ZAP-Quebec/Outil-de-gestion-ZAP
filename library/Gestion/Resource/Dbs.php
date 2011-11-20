<?php
/**
 * Amazium Library
 *
 * @category   Amz
 * @package    Amz_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2009 Amazium (http://www.amazium.be)
 */

/**
 * Resource for creating multiple database adapters
 *
 * @uses       Zend_Application_Resource_Base
 * @category   Amz
 * @package    Amz_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2009 Amazium (http://www.amazium.be)
 */
class Gestion_Resource_Dbs extends Zend_Application_Resource_ResourceAbstract
{
    
    /**
     * Adapter to use
     *
     * @var array
     */
    protected $_db = array();
    
    /**
     * ZAP adapter
     *
     * @var boolean
     */
    protected $_defaultDb = null;

    /**
     * Adapter type to use
     * 
     * @return string
     */
    public function getAdapter($db)
    {
        $db = $this->isValidDb($db);
        if (isset($this->_options[$db]['adapter'])) {
            return $this->_options[$db]['adapter'];
        }
        return null; 
    }

    /**
     * Adapter parameters
     * 
     * @return array
     */
    public function getParams($db)
    {
        $db = $this->isValidDb($db);
        if (isset($this->_options[$db]['params'])) {
            return $this->_options[$db]['params'];
        }
        return array();
    }

    /**
     * Is this adapter the default table adapter?
     * 
     * @return void
     */
    public function isZAPTableAdapter($db)
    {
        $db = $this->isValidDb($db);
        if (isset($this->_options[$db]['isZAPTableAdapter'])) {
            return $this->_options[$db]['isZAPTableAdapter'];
        }
        return false;
    }

    /**
     * Retrieve initialized DB connection
     * 
     * @return null|Zend_Db_Adapter_Interface
     */
    public function getDbAdapter($db = null)
    {
        // check if the DB is valid
        $db = $this->isValidDb($db, true);
        if (is_null($db) && is_null($db = $this->_defaultDb)) {
            return null;
        }
        
        if ((!isset($this->_db[$db]) || (null === $this->_db[$db])) 
            && (null !== ($adapter = $this->getAdapter($db)))
        ) {
            $this->_db[$db] = Zend_Db::factory($adapter, $this->getParams($db));
        }
        return $this->_db[$db];
    }
    
    /**
     * Defined by Zend_Application_Resource_IResource
     *
     * @return void
     */
    public function init()
    {
        if (is_null($this->_defaultDb)) {
            $options = $this->getOptions();
            $defaultDb = null;
            foreach ($options as $db=>$dbOptions) {
                if (null !== ($adapter = $this->getDbAdapter($db))) {
                    if ($this->isZAPTableAdapter($db) || is_null($defaultDb)) {
                        $defaultDb = $db;
                    }
                }
            }
            if (!is_null($defaultDb)) {
                $this->_defaultDb = $defaultDb;
                Zend_Db_Table::setZAPAdapter($this->getDbAdapter($defaultDb));
            }
        }
    }
    
    /**
     * Check if a database key is valid
     *
     * @param string $db
     * @param boolean $revertToZAPDb
     * @return string
     */
    public function isValidDb($db, $revertToZAPDb = false)
    {
        $db = strtolower(trim($db));
        if (!in_array($db, array_keys($this->_options))) {
            if (!$revertToZAPDb) {
                $db = $this->_defaultDb;
            } else {
                throw new Zend_Application_Resource_Exception('Invalid database specified');
            }
        }
        return $db;
    }

}

