<?php

class ZAP_Model_InvoicesItemsMapper {
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
            $this->setDbTable('ZAP_Model_DbTable_InvoicesItems');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Requests $request) {
        $data = array(
            'id_node'          => $request->getId_node(),
            'id_user'          => $request->getId_user(),
            'id_user_assigned' => $request->getId_user_assigned(),
            'date_open'        => $request->getDate_open(),
            'date_close'       => $request->getDate_close(),
            'status'           => $request->getStatus(),
            'summary'          => $request->getSummary(),
            'priority'         => $request->getPriority(),
            'description'      => $request->getDescription(),
        );

        if (null === ($id = $request->getId()) OR $id == NULL) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        throw new Exception('Delete user - action is not allowed');
    }

    public function find($id, ZAP_Model_InvoicesItems $item) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $item->setId($row->id)
             ->setCategory($row->category)
             ->setUnit_cost($row->unit_cost)
             ->setDescription($row->description);
    }

    public function getInvoiceItem($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        return $row->toArray();
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Invoices();
            $entry ->setId($row->id)
                   ->setId_invoice($row->id_invoice)
                   ->setId_item($row->id_item)
                   ->setOrder($row->order)
                   ->setNumber($row->number)
                   ->setNote($row->note);

            $entries[] = $entry;
        }

        return $entries;
    }

    // Fonctions specifiques
    public function fetchById($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        return $row->toArray();
    }

    public function getItemsName() {
        $resultSet = $this->getDbTable()->fetchAll(null, 'description ASC');
        $entries   = array();
        $entries[''] = null;
        foreach ($resultSet as $row) {
            $entries[$row->id] = $row->description;
        }
        return $entries;
    }

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
