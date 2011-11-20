<?php
/**
 * NodesWifidog2
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * NodesWifidog2 model
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class ZAP_Model_DbTable_NodesWifidog2 extends Zend_Db_Table_Abstract {

    protected $_schema = 'public';
    protected $_name = 'nodes';

    public function __construct()
    {
	$this->setZAPAdapter('db1'); 
        $this->_setup();
        $this->init();
    }

    public function get($id) {
        $rowset = $this->fetchAll("node_id = '".$id."'");

        $rowCount = count($rowset);
        $result = FALSE;

        if ($rowCount > 0) {
            $result = $rowset->current();
        }

        return $result;
    }

}
