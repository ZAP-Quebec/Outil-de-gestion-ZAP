<?php

// application/models/GuestbookMapper.php

class ZAP_Model_MoijezapMapper
{
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
            $this->setDbTable('ZAP_Model_DbTable_Moijezap');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Moijezap $moijezap)
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




    public function find($id, ZAP_Model_Moijezap $moijezap)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $moijezap->setId($row->id)
                  ->setLatitude($row->latitude)
                  ->setLongitude($row->longitude)
		  ->setNom($row->nom)
		  ->setActive($row->active);
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
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Moijezap();
            $entry->setId($row->id)
                  ->setLatitude($row->latitude)
                  ->setLongitude($row->longitude)
		  ->setNom($row->nom)
		  ->setActive($row->active)
                  /*->setCreated($row->created)*/
                  ->setMapper($this);
            $entries[] = $entry;
        }
        return $entries;
    }
}
