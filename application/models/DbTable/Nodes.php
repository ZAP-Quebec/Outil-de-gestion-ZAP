<?php
/**
 * Fichier nodes
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele nodes
 *
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_DbTable_Nodes extends Zend_Db_Table_Abstract {
    protected $_schema = 'gestion';
    protected $_name = 'nodes';
    protected $_primary = array('id');

    public function __construct() {
        $this->setZAPAdapter('db1');
        $this->_setup();
        $this->init();
    }
}
