<?php
/**
 * Fichier groups
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele groups
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_DbTable_Groups extends Zend_Db_Table_Abstract {
    protected $_schema = 'gestion';
    protected $_name = 'groups';
    protected $_primary = array('id');
    protected $_dependentTables = array('ZAP_Model_DbTable_Privileges');

    public function __construct() {
        $this->setZAPAdapter('db1');
        $this->_setup();
        $this->init();
    }
}
