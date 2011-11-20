<?php
/**
 * Fichier authentification
 *
 * @author     Frederic Sheedy
 * @category   core
 * @package    core
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele authentification
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class Authentification {
    /**
     * Enregistrement de l'information session
     */
    public function userInformation($idUser) {
        Zend_Loader::loadClass('Users');
        $table = new Users();
        
        $rowset = $table->find($idUser);
        
        $rowCount = count($rowset);
        
        $result = FALSE;
        
        if ($rowCount > 0) {
            $row = $rowset->current();
            $data = Zend_Auth::getInstance()->getStorage();
            $userData = $data->read();
            $userData->id_user = $row->id_user;
            $userData->firstname = $row->firstname;
            $userData->lastname = $row->lastname;
            $userData->status = $row->status;
            //$userData->rights = $row->rights;
            $userData->longitude = $row->longitude;
            $userData->latitude = $row->latitude;
            $userData->phone = $row->phone;
            $userData->mobile = $row->mobile;
            $data->write($userData);
        } else {
            $result = TRUE;
        }
        
		return $result;
	}
    
    /**
     * Verification pour la connexion
     */
    public function userVerification($idUser) {
        Zend_Loader::loadClass('Users');
        $table = new Users();
        
        $rowset = $table->find($idUser);
        
        $rowCount = count($rowset);
        
        $result = FALSE;
        
        if ($rowCount > 0) {
            $row = $rowset->current();
            if ($row->status == 0) {
                $result = FALSE;
            } else {
                $result = TRUE;
            }
        }
        
		return $result;
	}
}