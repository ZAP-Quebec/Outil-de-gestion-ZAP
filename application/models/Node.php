<?php
/**
 * Fichier node
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele nodes
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class Node {
    public function update($id_node, $id_router, $id_antenna, $contact_administration, $contact_technical, $images, $internet_supplier_name, $internet_modem_model) {
        Zend_Loader::loadClass('Nodes');
        $table = new Nodes();
        
        $data = array(
                    'id_router'              => $id_router,
                    'id_antenna'             => $id_antenna,
                    'contact_administration' => $contact_administration,
                    'contact_technical'      => $contact_technical,
                    'images'                 => $images,
                    'internet_supplier_name' => $internet_supplier_name,
                    'internet_modem_model'   => $internet_modem_model
                );
        
        $where = $table->getAdapter()->quoteInto('id_node = ?', $id_node);
        
        $information = $table->update($data, $where);
}

    public function add($id_node) {
        // V�rification des variables
        // TODO::Security
        
        Zend_Loader::loadClass('Nodes');
        $table = new Nodes();
        
        $data = array(
                    'id_node'                => $id_node,
                    'contact_administration' => NULL,
                    'contact_technical'      => NULL,
                    'images'                 => NULL,
                    'id_antenna'             => NULL,
                    'id_router'              => NULL,
                    'internet_supplier_name' => NULL,
                    'internet_modem_model'   => NULL
                );
        
        $table->insert($data);
	}

    public function view($id_node) {
        Zend_Loader::loadClass('Nodes');
        $table = new Nodes();
        
        $rowset = $table->fetchAll("id_node = '".$id_node."'");
        
        $rowCount = count($rowset);
        $result = FALSE;
        
        if ($rowCount > 0) {
            $result = $rowset->current();
        }
        
		return $result;
	}
    
    public function listAll($baseUrl) {
        Zend_Loader::loadClass('NodesWifidog');
        $table = new NodesWifidog();

        $rowset = $table->fetchAll(null, 'name');
        
        
        $view = '';
        $rowCount = count($rowset);
        
        if ($rowCount > 0) {
            foreach ($rowset as $row) {
    			$view .= '<a href="'.$baseUrl.'/node/view/'.$row->node_id.'">'.$row->name.'</a><br />';
    		}
        } else {
            $view = FALSE;
        }
		return $view;
	}
    
    public function listOption() {
        Zend_Loader::loadClass('NodesWifidog'); 
        $table = new NodesWifidog();
        $rowset = $table->fetchAll(null, 'name');
        
        $view = array();
        $rowCount = count($rowset);
        
        if ($rowCount > 0) {
            foreach ($rowset as $row) {
    			$view[$row->node_id] = $row->name;
    		}
        } else {
            $view = FALSE;
        }
		return $view;
	}
/*
    public function listOption() {
        Zend_Loader::loadClass('NodesWifidog'); 
        $table = new NodesWifidog();
        $rowset = $table->fetchAll(null, 'name');
        
        $view = '';
        $rowCount = count($rowset);
        
        if ($rowCount > 0) {
            foreach ($rowset as $row) {
    			$view .= '<option value="'.$row->node_id.'">'.$row->name.'</option>';
    		}
        } else {
            $view = FALSE;
        }
		return $view;
	}*/
	
	public function getName($id_node) {
	    Zend_Loader::loadClass('NodesWifidog');
        $table = new NodesWifidog();
        
        $rowset = $table->fetchAll("node_id = '".$id_node."'");
        
        $rowCount = count($rowset);
        $result = FALSE;
        
        if ($rowCount > 0) {
            $node = $rowset->current();
			$result = $node->name;
        }
        
		return $result;
	}
    
	public function getStatus($node_status) {
        switch($node_status) {
            case 'DEPLOYED':
                $result= 'D&eacute;ploy&eacute;';
                break;
            case 'IN_PLANNING':
                $result= 'En planification';
                break;
            case 'IN_TESTING':
                $result= 'En essai';
                break;
            case 'NON_WIFIDOG_NODE':
                $result= 'Sympathisant';
                break;
            case 'PERMANENTLY_CLOSED':
                $result= 'Fermeture permanente';
                break;
            case 'TEMPORARILY_CLOSED':
                $result= 'Fermeture temporaire';
                break;
            default:
                $result = 'Inconnu';
                break;
        }
        
		return $result;
	}
}
