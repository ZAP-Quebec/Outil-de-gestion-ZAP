<?php
/**
 * Fichier requests
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele requests
 *
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_DbTable_Requests extends Zend_Db_Table_Abstract {
    protected $_schema = 'gestion';
    protected $_name = 'requests';
    protected $_primary = array('id');

    public function __construct() {
        $this->setZAPAdapter('db1');
        $this->_setup();
        $this->init();
    }
}
