<?php

class ZAP_Model_CustomersMapper {
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
            $this->setDbTable('ZAP_Model_DbTable_Customers');
        }
        return $this->_dbTable;
    }

    public function save(ZAP_Model_Customers $customer) {
        
        $data = array(
                    'deleted'           => 0,
                    'date_modified'     => date('Y-m-d H:i'),
                    'name'              => $customer->getName(),
                    'type'              => $customer->getType(),
                    'contact_firstname' => $customer->getcontact_firstname(),
                    'contact_lastname'  => $customer->getcontact_lastname(),
                    'contact_position'  => $customer->getcontact_position(),
                    'address'           => $customer->getaddress(),
                    'city'              => $customer->getcity(),
                    'province'          => $customer->getprovince(),
                    'postalcode'        => $customer->getpostalcode(),
                    'phone_personal'    => $customer->getphone_personal(),
                    'phone_office'      => $customer->getphone_office(),
                    'phone_cell'        => $customer->getphone_cell(),
                    'fax'               => $customer->getfax(),
                    'email'             => $customer->getemail(),
                    'url'               => $customer->geturl(),
                    'contract_date'     => $customer->getcontract_date(),
                    'note'              => $customer->getnote(),
                    'status'            => $customer->getstatus(),
                    'next_follow_date'  => $customer->getnext_follow_date());

        
        if ($customer->getcontract_date() == '') {
            $data['contract_date'] = NULL;  
        }
                
        if ($customer->getnext_follow_date() == '') {
            $data['next_follow_date'] = NULL;  
        }
        
        if (null === ($id = $customer->getId()) OR $id == NULL) {
            unset($data['id']);
            $data['date_creation'] = date('Y-m-d H:i');
            $result = $this->getDbTable()->insert($data);
            return $result;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
           
        }
    }

    public function delete($id) {
        $data = array('deleted'  => TRUE);
        $this->getDbTable()->update($data, array('id = ?' => $id));
    }

    public function getNamebyId($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        } else {
           $row = $result->current();
           return $row->name;
        } 

    }
    public function find($id, ZAP_Model_Customers $customer) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $customer ->setId($row->id)
                  ->setDate_creation($row->date_creation)
                  ->setDate_modified($row->date_modified)
                  ->setName($row->name)
                  ->setType($row->type)
                  ->setContact_firstname($row->contact_firstname)
                  ->setContact_lastname($row->contact_lastname)
                  ->setContact_position($row->contact_position)
                  ->setAddress($row->address)
                  ->setCity($row->city)
                  ->setProvince($row->province)
                  ->setPostalcode($row->postalcode)
                  ->setPhone_personal($row->phone_personal)
                  ->setPhone_office($row->phone_office)
                  ->setPhone_cell($row->phone_cell)
                  ->setFax($row->fax)
                  ->setEmail($row->email)
                  ->setUrl($row->url)
                  ->setContract_date($row->contract_date)
                  ->setNote($row->note)
                  ->setStatus($row->status)
                  ->setNext_follow_date($row->next_follow_date);
    }
    
    public function getCustomer($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();

        return $row->toArray();
    }

    public function fetchAll($where = NULL) {
        if ($where) {
            $resultSet = $this->getDbTable()->fetchAll('deleted= FALSE AND '.$where, 'id ASC');
        } else {
            $resultSet = $this->getDbTable()->fetchAll('deleted= FALSE', 'id ASC');
        }
        
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new ZAP_Model_Customers();
            $entry ->setId($row->id)
                   ->setDate_creation($row->date_creation)
                   ->setDate_modified($row->date_modified)
                   ->setName($row->name)
                   ->setType($row->type)
                   ->setContact_firstname($row->contact_firstname)
                   ->setContact_lastname($row->contact_lastname)
                   ->setContact_position($row->contact_position)
                   ->setAddress($row->address)
                   ->setCity($row->city)
                   ->setProvince($row->province)
                   ->setPostalcode($row->postalcode)
                   ->setPhone_personal($row->phone_personal)
                   ->setPhone_office($row->phone_office)
                   ->setPhone_cell($row->phone_cell)
                   ->setFax($row->fax)
                   ->setEmail($row->email)
                   ->setUrl($row->url)
                   ->setContract_date($row->contract_date)
                   ->setNote($row->note)
                   ->setStatus($row->status)
                   ->setNext_follow_date($row->next_follow_date);

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

    public function getCustomersName() {
        $resultSet = $this->getDbTable()->fetchAll(null, 'name ASC');
        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[$row->id] = $row->name;
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
