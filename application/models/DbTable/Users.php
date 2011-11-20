<?php
/**
 * Fichier users
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele users
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_DbTable_Users extends Zend_Db_Table_Abstract {
    protected $_schema = 'gestion';
    protected $_name = 'users';
    protected $_primary = array('id');
    protected $_dependentTables = array('ZAP_Model_DbTable_Privileges');

    public function __construct() {
        $this->setZAPAdapter('db1');
        $this->_setup();
        $this->init();
    }
}
