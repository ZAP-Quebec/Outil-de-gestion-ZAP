<?php
/**
 * Moijezap
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Moijezap model
 *
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class ZAP_Model_DbTable_Moijezap extends Zend_Db_Table_Abstract
{
    protected $_name    = 'places';
    protected $_primary = 'id';

    public function __construct()
    {
	$this->setZAPAdapter('db2'); 
        $this->_setup();
        $this->init();
    }
}
