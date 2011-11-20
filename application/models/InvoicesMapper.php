<?php

class ZAP_Model_InvoicesMapper {
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
            $this->setDbTable('ZAP_Model_DbTable_Invoices');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Invoices $request) {
        $data = array(
            'id'          => $request->getId(),
            'id_customer' => $request->getId_customer(),
            'date'        => $request->getDate(),
            'status'      => $request->getStatus(),
            'note'        => $request->getNote()
        );

        if (null === ($id = $request->getId()) OR $id == NULL) {
            unset($data['id']);
            $result = $this->getDbTable()->insert($data);
            return $result;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
            return 0;
        }
    }

    public function delete($id) {
        throw new Exception('Delete user - action is not allowed');
    }

    public function find($id, ZAP_Model_Invoices $invoice) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $invoice->setId($row->id)
                ->setId_customer($row->id_customer)
                ->setDate($row->date)
                ->setStatus($row->status)
                ->setNote($row->note);
    }

    public function getInvoice($id) {
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
                   ->setId_customer($row->id_customer)
                   ->setDate($row->date)
                   ->setStatus($row->status)
                   ->setNote($row->note);

            $entries[] = $entry;
        }

        return $entries;
    }

    // Fonctions specifiques
    public function fetchByCustomer($id) {
        $resultSet = $this->getDbTable()->fetchAll("id_customer = '".$id."'");
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Invoices();
            $entry ->setId($row->id)
                   ->setId_customer($row->id_customer)
                   ->setDate($row->date)
                   ->setStatus($row->status)
                   ->setNote($row->note);

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
