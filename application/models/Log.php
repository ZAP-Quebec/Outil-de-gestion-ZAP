<?php
/**
 * History
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * History Class
 *
 * @version    1.0
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_Log {
    /**
     * Add
     */
    public function add($original_id, $module, $action, $newValue, $oldValue = null) {
        $auth = Zend_Auth::getInstance();
        $idUser = $auth->getIdentity()->user_id;
                
        if (!$oldValue) {
            $logs = new ZAP_Model_Logs();
            $row = $logs->createRow();

            $row->id_user = $idUser;
            $row->date_log = date('Y-m-d');
            $row->time_log = date('H:i');
            $row->module = $module;
            $row->action = $action;
            $row->value = serialize($newValue);
            $row->original_id = $original_id;

            $row->save();
        } else {
            $logs = new ZAP_Model_Logs();
            $row = $logs->createRow();

            $row->id_user = $idUser;
            $row->date_log = date('Y-m-d');
            $row->time_log = date('H:i');
            $row->module = $module;
            $row->action = $action;
            $row->original_id = $original_id;

            $modification = array();
            foreach ($newValue as $key => $value) {
                if ($oldValue[$key] != $value) {
                    $modification[$key] = $value;
                }
            }
            //die();
            $row->value = serialize($modification);

            $row->save();
        }

        return;
    }

    public function fetchByRequest($id_request) {
        $logs = new ZAP_Model_Logs();
    }
}