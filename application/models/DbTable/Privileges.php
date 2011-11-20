<?php
/**
 * Fichier privileges
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Modele invoicesLines
 *
 * @copyright  2009 Frederic Sheedy
 * @license    GNU GPL V3
 */
class ZAP_Model_DbTable_Privileges extends Zend_Db_Table_Abstract {
    protected $_schema = 'gestion';
    protected $_name = 'privileges';
    protected $_primary = array('id');

    protected $_referenceMap    = array(
        'user_id' => array(
            'columns'           => array('user_id'),
            'refTableClass'     => 'ZAP_Model_DbTable_Users',
            'refColumns'        => array('id')
        ),
        'group_id' => array(
            'columns'           => array('group_id'),
            'refTableClass'     => 'ZAP_Model_DbTable_Groups',
            'refColumns'        => array('id')
        )
    );

    public function __construct() {
        $this->setZAPAdapter('db1');
        $this->_setup();
        $this->init();
    }
}
