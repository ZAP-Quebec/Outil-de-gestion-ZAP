<?php

class ZAP_Model_UsersMapper {
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('ZAP_Model_DbTable_Users');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Users $user, $insert = false) {
        $data = array(
            'id'        => $user->getId(),
            'status'    => $user->getStatus(),
            'title'      => $user->getTitle(),
            'longitude' => $user->getLongitude(),
            'latitude'  => $user->getLatitude(),
            'phone'     => $user->getPhone(),
            'mobile'    => $user->getMobile(),
            'firstname' => $user->getFirstname(),
            'lastname'  => $user->getLastname(),
        );

        if ($insert == false) {
            $id = $user->getId();
            $this->getDbTable()->update($data, array('id = ?' => $id));
        } else {
            $this->getDbTable()->insert($data);
        }
    }

    public function delete($id) {
      /*if ($id > 0) {
          $where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
          $this->getDbTable()->delete($where);
      }*/
      throw new Exception('Delete user - action is not allowed');
    }

    public function find($id, ZAP_Model_Users $user) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $user->setId($row->id)
             ->setStatus($row->status)
             ->setTitle($row->title)
		     ->setLongitude($row->longitude)
		     ->setLatitude($row->latitude)
             ->setPhone($row->phone)
             ->setMobile($row->mobile)
             ->setFirstname($row->firstname)
             ->setLastName($row->lastname);
    }

    public function getUser($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();

        return $row->toArray();
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll(null, 'lastname ASC');
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Users();
            $entry->setId($row->id)
                  ->setStatus($row->status)
                  ->setTitle($row->title)
                  ->setLongitude($row->longitude)
                  ->setLatitude($row->latitude)
                  ->setPhone($row->phone)
                  ->setMobile($row->mobile)
                  ->setFirstname($row->firstname)
                  ->setLastName($row->lastname)
                  ->setMapper($this);

            $entries[] = $entry;
        }

        return $entries;
    }

    // Fonctions specifiques
    public function isAllowed($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return FALSE;
        }
        $user = $result->current();

        if ($user->status == 'allowed') {
            return TRUE;
        }

        return FALSE;
    }

    public function getUsersName() {
        $resultSet = $this->getDbTable()->fetchAll(null, 'firstname ASC');
        $entries   = array();
        $entries[''] = null;
        foreach ($resultSet as $row) {
            $entries[$row->id] = $row->firstname.' '.$row->lastname;
        }
        return $entries;
    }

    public function getUserName($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        return $row->firstname.' '.$row->lastname;;
    }
}
