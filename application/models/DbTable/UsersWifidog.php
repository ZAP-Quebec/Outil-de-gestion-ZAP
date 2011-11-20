<?php
/**
 * NodesWifidog
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * NodesWifidog model
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class ZAP_Model_DbTable_UsersWifidog extends Zend_Db_Table_Abstract {
    protected $_schema = 'public';
    protected $_name = 'users';
    protected $_primary = array('user_id');

    public function __construct() {
        $this->setZAPAdapter('db1');
        $this->_setup();
        $this->init();
    }
}
