<?php
/**
 * Fichier logs
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele logs
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class ZAP_Model_Logs extends Zend_Db_Table_Abstract {
    
    protected $_schema = 'gestion';
    protected $_name = 'logs';
    protected $_primary = 'id_log';
    
    public function __construct()
    {
        $this->setZAPAdapter('db1'); 
        $this->_setup();
        $this->init();
    }
}