<?php
/**
 * NodesWifidogMapper
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * ZAP_Model_NodesWifidog class
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class ZAP_Model_NodesWifidogMapper {

    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('ZAP_Model_DbTable_NodesWifidog');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_NodesWifidog $nodeWifidog)
    {
        $data = array(
            'latitude'  => $moijezap->getLatitude(),
            'longitude' => $moijezap->getLongitude(),
	    'nom'       => $moijezap->getNom(),
	    'active'    => $moijezap->getActive(),
            /*'created'   => date('Y-m-d H:i:s'),*/
        );

        if (null === ($id = $moijezap->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id)
    {
      if ($id > 0) {
	  $where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
	  $this->getDbTable()->delete($where);
      }
    }




    public function find($id, ZAP_Model_NodesWifidog $nodesWifidog)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $nodesWifidog->setNode_id($row->node_id)
                     //->setLatitude($row->latitude)
                     //->setLongitude($row->longitude)
                     ->setName($row->name);
                     //->setActive($row->active);
    }

    public function getPlace($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

	return $row->toArray();
    }

    public function fetchAll()
    {
        $order = new Zend_Db_Expr('lower(name)');
        $resultSet = $this->getDbTable()->fetchAll(null, $order);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_NodesWifidog();
            $entry->setNode_Id($row->node_id)
                  ->setName($row->name)
		  ->setNode_deployment_status($row->node_deployment_status)
                  ->setMapper($this);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getNodesName() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array('' => '');
        foreach ($resultSet as $row) {
            $entries[$row->node_id] = $row->name;
        }
        return $entries;
    }
}