<?php
/**
 * Fichier nodes
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
class Nodes extends Zend_Db_Table {
    protected $_schema = 'gestion';
    protected $_name = 'nodes';
    protected $_primary = array('id_node');
}