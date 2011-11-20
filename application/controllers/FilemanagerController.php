<?php
/**
 * Router Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Router Controller Class
 *
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 * @version    1.0
 * @since      Class available since Release 1.0
 */
class FilemanagerController extends Zend_Controller_Action {
    /**
     * Init
     */
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->user = Zend_Auth::getInstance()->getIdentity();
        $this->view->user = $this->user;
    }
    /**
     * Index action
     */
    function indexAction() {
        $dir = "/var/www/demo.gestion.zapquebec.org/data/filemanager/";
        // Demande dossier
        $user_dir = $this->_request->getParam('dir');

        if (!strstr($user_dir, "..") || !strstr($user_dir, "./")) {
            $dir = $dir . $user_dir;
        }

        // Demande fichier
        if ($this->_request->getParam('file')) {
            $file = $this->_request->getParam('file');
            if (strstr($file, "..") || strstr($file, "./")) {
                die('Pas les droits');
            }
            //die(urlencode($file));
            header("Content-Type: application/octet-stream");
            header("Content-Disposition:attachment;filename=". rawurlencode($file) . "");
            readfile($dir. $file);
            die();
        }

        $files = array();
        // Open a known directory, and proceed to read its contents
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' and $file != '..') {
                        $files[$file]['name']= $file;
                        $files[$file]['type']= filetype($dir . $file);
                    }
                }
                closedir($dh);
            }
        } else {
            die('Le fichier/dossier demandé n\'existe pas');
        }
        
        asort($files);
        $this->view->files = $files;
        $this->view->user_dir = $user_dir;
    }

 }
