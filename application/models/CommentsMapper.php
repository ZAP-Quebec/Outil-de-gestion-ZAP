<?php

class ZAP_Model_CommentsMapper {
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
            $this->setDbTable('ZAP_Model_DbTable_Comments');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Comments $comment) {
        if (null === ($id = $comment->getId()) OR $id == NULL) {
            $data = array(
            'id_user'      => $comment->getId_user(),
            'id_reference' => $comment->getId_reference(),
            'module'       => $comment->getModule(),
            'date'         => $comment->getDate(),
            'time'         => $comment->getTime(),
            'status'       => $comment->getStatus(),
            'comment'      => $comment->getComment());

            $this->getDbTable()->insert($data);
        } else {
            $data = array('comment' => $comment->getComment());
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
                ->setId_item($row->id_item)
                ->setOrder($row->order)
                ->setNumber($row->number)
                ->setNote($row->note);
    }

    public function fetchById($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        return $row->toArray();
    }

    // Fonctions specifiques
    public function fetchByRequest($id_request, $module = NULL) {
        if ($module) {
            $resultSet = $this->getDbTable()->fetchAll("module = '".$module."' AND id_reference = '".$id_request."'", array('date DESC', 'time DESC'));
        } else {
            $resultSet = $this->getDbTable()->fetchAll("id_reference = '".$id_request."'", array('date DESC', 'time DESC')); 
        }
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Comments();
            $entry ->setId($row->id)
                   ->setId_user($row->id_user)
                   ->setId_reference($row->id_reference)
                   ->setModule($row->module)
                   ->setDate($row->date)
                   ->setTime($row->time)
                   ->setStatus($row->status)
                   ->setComment($row->comment);
            $entries[] = $entry;
        }

        return $entries;
    }

}
