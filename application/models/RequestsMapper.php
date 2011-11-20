<?php

class ZAP_Model_RequestsMapper {
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
            $this->setDbTable('ZAP_Model_DbTable_Requests');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Requests $request) {
        // Ajout
        $log = new ZAP_Model_Log();
        if (null === ($id = $request->getId()) OR $id == NULL) {
            $data = array(
                'id_node'          => $request->getId_node(),
                'id_user'          => $request->getId_user(),
                'id_user_assigned' => $request->getId_user_assigned(),
                'date_open'        => date('Y-m-d H:i'),
                'date_close'       => $request->getDate_close(),
                'status'           => 'NEW',
                'summary'          => $request->getSummary(),
                'priority'         => $request->getPriority(),
                'description'      => $request->getDescription());
            $id = $this->getDbTable()->insert($data);

            $log->add($id, 'REQUEST', 'ADD', $data);
            return $id;
        } else {
            $data = array(
                'id_node'          => $request->getId_node(),
                'id_user'          => $request->getId_user(),
                'id_user_assigned' => $request->getId_user_assigned(),
                'summary'          => $request->getSummary(),
                'priority'         => $request->getPriority(),
                'description'      => $request->getDescription());

           if ($request->getDate_close() != null) {
               $data['date_close'] = date('Y-m-d H:i');
               $data['status'] = "CLOSED";
           } elseif ($request->getId_user_assigned() != null) {
               $data['date_close'] = null;
               $data['status'] = "ASSIGNED";
           } else {
               $data['status'] = "NEW";
           }
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        throw new Exception('Delete user - action is not allowed');
    }

    public function find($id, ZAP_Model_Requests $request) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $request->setId($row->id)
                ->setId_node($row->id_node)
                ->setId_user($row->id_user)
                ->setId_user_assigned($row->id_user_assigned)
                ->setDate_open($row->date_open)
                ->setDate_close($row->date_close)
                ->setStatus($row->status)
                ->setSummary($row->summary)
                ->setPriority($row->priority)
                ->setDescription($row->description);
    }

    public function getRequest($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        return $row->toArray();
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll(null, 'id ASC');
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Requests();
            $entry ->setId($row->id)
                   ->setId_node($row->id_node)
                   ->setId_user($row->id_user)
                   ->setId_user_assigned($row->id_user_assigned)
                   ->setDate_open($row->date_open)
                   ->setDate_close($row->date_close)
                   ->setStatus($row->status)
                   ->setSummary($row->summary)
                   ->setPriority($row->priority)
                   ->setDescription($row->description);

            $entries[] = $entry;
        }

        return $entries;
    }

    // Fonctions specifiques
    public function fetchByUser($id) {
        $resultSet = $this->getDbTable()->fetchAll("id_user_assigned = '".$id."'");
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Requests();
            $entry ->setId($row->id)
                   ->setId_node($row->id_node)
                   ->setId_user($row->id_user)
                   ->setId_user_assigned($row->id_user_assigned)
                   ->setDate_open($row->date_open)
                   ->setDate_close($row->date_close)
                   ->setStatus($row->status)
                   ->setSummary($row->summary)
                   ->setPriority($row->priority)
                   ->setDescription($row->description);

            $entries[] = $entry;
        }

        return $entries;
    }
    /*public function isAllowed($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return FALSE;
        }
        $user = $result->current();

        if ($user->status == 'allowed') {
            return TRUE;
        }

        return FALSE;
    }*/
}
