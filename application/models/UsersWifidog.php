<?php
/**
 * Fichier users
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele users
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_UsersWifidog {

    public function getId($username) {
        $table = new ZAP_Model_DbTable_UsersWifidog();
        //$rowset = $table->fetchRow('username = "' . $username .'"');
        $row = $table->fetchRow($table->select()
                                         ->where('username = ?', $username));
        $rowcount = count($row);

        if ($rowcount > 0) {
            return $row->user_id;
        }

        return FALSE;
    }

    public function fetchByEmail($email) {
        $table = new ZAP_Model_DbTable_UsersWifidog();
        //$rowset = $table->fetchRow('username = "' . $username .'"');
        $row = $table->fetchRow($table->select()
                                         ->where('email = ?', $email));
        $rowcount = count($row);

        if ($rowcount > 0) {
            return $row;
        }

        return FALSE;
    }

    public function getEmail($user_id) {
        $table = new ZAP_Model_DbTable_UsersWifidog();
        //$rowset = $table->fetchRow('username = "' . $username .'"');
        $row = $table->fetchRow($table->select()
                                         ->where('user_id = ?', $user_id));
        $rowcount = count($row);

        if ($rowcount > 0) {
            return $row->email;
        }

        return FALSE;
    }
}
