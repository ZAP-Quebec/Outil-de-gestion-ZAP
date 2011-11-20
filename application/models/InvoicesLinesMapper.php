<?php

class ZAP_Model_InvoicesLinesMapper {
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
            $this->setDbTable('ZAP_Model_DbTable_InvoicesLines');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_InvoicesLines $line) {
        $data = array(
            'description'    => $line->getdescription(),
            'number'     => $line->getnumber(),
            'note'       => $line->getnote(),
            'unit_price'       => $line->getunit_price(),
            'order'      => $line->getorder());

        if (null === ($id = $line->getId()) OR $id == NULL) {
            unset($data['id']);
            $data['id_invoice'] = $line->getid_invoice();
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        throw new Exception('Delete user - action is not allowed');
    }

    public function find($id, ZAP_Model_InvoicesLines $invoice) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $invoice->setId($row->id)
                ->setId_invoice($row->id_invoice)
                ->setDescription($row->description)
                ->setOrder($row->order)
                ->setNumber($row->number)
                ->setUnit_price($row->unit_price)
                ->setNote($row->note);
    }

    public function getInvoiceLines($id_invoice) {
        //$result = $this->getDbTable()->find($id);
        $resultSet = $this->getDbTable()->fetchAll("id_invoice = '".$id_invoice."'", 'order ASC');
        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = $row->toArray();
        }

        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Invoices();
        $entry->setId($row->id)
                ->setId_invoice($row->id_invoice)
                ->setDescription($row->description)
                ->setOrder($row->order)
                ->setNumber($row->number)
                ->setUnit_price($row->unit_price)
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

    public function fetchByInvoice($id_invoice) {
        $resultSet = $this->getDbTable()->fetchAll("id_invoice = '".$id_invoice."'", 'order ASC');
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_InvoicesLines();
            $entry->setId($row->id)
                ->setId_invoice($row->id_invoice)
                ->setDescription($row->description)
                ->setOrder($row->order)
                ->setNumber($row->number)
                ->setUnit_price($row->unit_price)
                ->setNote($row->note);

            $entries[] = $entry;
        }

        return $entries;
    }
    
    public function fetchByInvoiceDesc($id_invoice) {
        $resultSet = $this->getDbTable()->fetchAll("id_invoice = '".$id_invoice."'", 'order DESC');
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_InvoicesLines();
            $entry->setId($row->id)
                ->setId_invoice($row->id_invoice)
                ->setDescription($row->description)
                ->setOrder($row->order)
                ->setNumber($row->number)
                ->setUnit_price($row->unit_price)
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
