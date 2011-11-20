<?php
/**
 * Node Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Node Controller Class
 *
 * @version    1.0
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class NodeController extends Zend_Controller_Action {
    /**
     * Init
     */

    public function preDispatch()
    {
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()) {
        $this->username = $auth->getIdentity()->username;
    } else {
        $this->_helper->redirector('login', 'authentification');
    }
    }
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->user = Zend_Auth::getInstance()->getIdentity();
        $this->view->user = $this->user;
    }

    /**
     * View node
     */
    public function updateAction() {

        $this->view->messages = ($this->_helper->flashMessenger->getMessages());

        $request = $this->getRequest();
        $form    = new ZAP_Form_Node();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Nodes($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_places = new ZAP_Model_Nodes();
                  $oldValue = $old_places->getPlace($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'NODE_TODO', 'UPDATE', $form->getValues(), $oldValue);
                
                $places->save();
                return $this->_helper->redirector('index');
            }
        }
        
        $id = $this->_getParam('id', 0);
        if ($id) {
            /*$places = new ZAP_Model_Nodes();
            $form->populate($places->getPlace($id));*/

            $nodeWifidog = new ZAP_Model_DbTable_NodesWifidog2();
//Zend_Debug::dump($nodeWifidog->find($id));
//die();
            $node_wifidog = $nodeWifidog->get($id);
            $this->view->nodeWifidog = $node_wifidog;
            if ($node_wifidog->home_page_url != NULL) {
            preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->home_page_url, $matches);
            $this->view->home_page_domain = $matches[1]; }

            if ($node_wifidog->map_url != NULL) {
            preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->map_url, $matches);
            $this->view->map_domain = $matches[1]; }

            // Gestion fichiers
            $dir = "/var/www/demo.gestion.zapquebec.org/data/node/";
            // Demande dossier
            $user_dir = $id . '/';

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
                asort($files);
            } else {
                // Aucun
                $files = FALSE;
            }

            $this->view->files = $files;
            $this->view->user_dir = $user_dir;

        }

        $form_upload    = new ZAP_Form_Upload();
        $this->view->form = $form;
        $this->view->form_upload = $form_upload;
    }

    /*function viewAction() {
        $form = new NodeForm();
        $form->setAction($this->_request->getBaseUrl().'/node/update');
        $form->submit->setLabel('Enregistrer');
        $this->view->form = $form;

            $id = $this->_request->getParam('id', 0);
            if ($id) {
                Zend_Loader::loadClass('NodeWifidog');
                $node_wifidog = NodeWifidog::View($id);
                $this->view->node_wifidog = $node_wifidog;
                $this->view->node_deployment_status = NodeWifidog::getStatus($node_wifidog->node_deployment_status);

                preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->home_page_url, $matches);
                $this->view->home_page_domain = $matches[1];

                preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->map_url, $matches);
                $this->view->map_domain = $matches[1];

                $nodes = new Nodes();
                $node = $nodes->fetchRow("id_node = '".$id."'");

                if (!$node) {
                    Node::Add($id);

                    $log = new Log();
                    $log->add($this->user->id_user, 'NODE', 'ADD', array("id_node" => $id));

                    $node = $nodes->fetchRow("id_node = '".$id."'");
                }

                $form->populate($node->toArray());
            }
    }*/
    
    /*
    function viewAction() {
        Zend_Loader::loadClass('Zend_Filter_StripTags');
        $f = new Zend_Filter_StripTags();
        $id_node = $f->filter($this->_request->getParam('id_node'));

        Zend_Loader::loadClass('NodeWifidog');
        $node_wifidog = NodeWifidog::View($id_node);
        $this->view->node_wifidog = $node_wifidog;
        $this->view->node_deployment_status = NodeWifidog::getStatus($node_wifidog->node_deployment_status);

        preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->home_page_url, $matches);
        $this->view->home_page_domain = $matches[1];

        preg_match('@^(?:http://)?([^/]+)@i', $node_wifidog->map_url, $matches);
        $this->view->map_domain = $matches[1];

        Zend_Loader::loadClass('Node');
        $node = Node::View($id_node);
        if ($node) {
            $this->view->node = $node;
        } else {
            $node = Node::Add($id_node);
            $node = Node::View($id_node);
        }


        Zend_Loader::loadClass('Contact');
        $this->view->contacts_option = Contact::listOption();
        
        $this->view->contact_administration_complete_name = Contact::getCompleteName($node->contact_administration);
        $this->view->contact_technical_complete_name = Contact::getCompleteName($node->contact_technical);
    }
*/

    /**
     * Update node
     */
    /*function updateAction() {
        $form = new NodeForm();
        $form->setAction($this->_request->getBaseUrl().'/node/update');
        $form->submit->setLabel('Enregistrer');
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $nodes = new Nodes();
                $id = $form->getValue('id_node');
                $form->setAction($this->_request->getBaseUrl().'/node/update');
                $row = $nodes->fetchRow("id_node = '".$id."'");
                $oldValue = $row->toArray();

                $row->contact_administration = $form->getValue('contact_administration');
                $row->contact_technical = $form->getValue('contact_technical');
                $row->id_router = $form->getValue('id_router');
                $row->id_antenna = $form->getValue('id_antenna');
                $row->internet_supplier_name = $form->getValue('internet_supplier_name');
                $row->internet_modem_model = $form->getValue('internet_modem_model');

                $row->save();

                $log = new Log();
                $log->add($this->user->id_user, 'NODE', 'UPDATE', $row->toArray(), $oldValue);

                $this->_redirect('/');
            } else {
                $form->populate($formData);
            }
        }
    }*/

    /**
     * List
     */
    function indexAction() {
        $nodesWifidog = new ZAP_Model_NodesWifidog();
        $this->view->entries = $nodesWifidog->fetchAll();
        /*$nodesWifidog = new NodesWifidog();
        $this->view->nodesWifidog = $nodesWifidog->fetchAll(null, 'name');*/
    }

    /*
     * upload
     
    function uploadAction() {
  //  die($_SERVER['DOCUMENT_ROOT']);
if( !empty($_FILES['file']) ) {
  $picture_temp = $_FILES['file']['tmp_name'];
  $picture = $_FILES['file']['name'];
  move_uploaded_file('/home/sheedy/ZAPQuebec/developpement/gestion/public/private/nodes/'.$picture);
} else {
    die('no work');
}
$id = $this->_request->getParam('id', 0);
$this->_redirect('/node/view/'.$id);
    }
    
    
    
}*/

    function uploadAction() {
        // id du node
        $id = $this->_request->getParam('id', 0);

        // initialisation du formulaire
        $form = new ZAP_Form_Upload();

        // révifier si les données sont envoyées
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {

                // succès - enregistrer le fichier dans le bon répertoire
                $uploadedData = $form->getValues();
                $basePath = '/var/www/demo.gestion.zapquebec.org/data/node/';

                // si le répertoire existe
                if (is_dir($dir)) {
                    $test=rename($form->file->getFileName(), $basePath . '/' . $id . '/' . $uploadedData['file']);
                } else {
                    mkdir($basePath . $id);
                    $test=rename($form->file->getFileName(), $basePath . '/' . $id . '/' . $uploadedData['file']);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'NODE_UPLOAD', 'ADD', array('filename' => $form->file->getFileName()));
                
                $this->_helper->FlashMessenger('Fichier téléchargé avec succès!');
                $this->_redirect('/node/update/id/'.$id);

                /*
                $fullFilePath = $form->file->getFileName();

                Zend_Debug::dump($uploadedData, '$uploadedData');
                Zend_Debug::dump($fullFilePath, '$fullFilePath');

                echo "done";
                die();
                */

            } else {
                $form->populate($formData);
            }
        }

        $this->view->form = $form;

    }

/*
    function uploadAction() {
        $id = $this->_request->getParam('id', 0);

        if(isset($_FILES['file'])) {
            $basePath = '/var/www/demo.gestion.zapquebec.org/data/node/';

    // on vérifie maintenant l'extension
    $type_file = $_FILES['file']['type'];

    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') && !strstr($type_file, 'pdf') && !strstr($type_file, 'doc') && !strstr($type_file, 'dox'))
    {
        exit("Le fichier n'est pas un fichier dans la liste autorisé, svp envoyer un courriel à fsheedy@zapquebec.org");
    }

            // Filename creation
            //$file = basename($_FILES['file']['name']);
            $nodes = new Nodes();
            $node = $nodes->fetchRow("id_node = '".$id."'");
            $image = split(':',$node->images);
            $count = count($image)-2;
            $num = $image[$count]+1;
            $file = $id.'-'.$num.'.jpg';

            echo $basePath.$file.'<br />';
            echo ($_FILES['file']['tmp_name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $basePath . $file)) {
                chmod($basePath . $file, 0777);
                $node->images = $node->images.$num.':';

                $node->save();
            }
        }

        $this->_redirect('/');
    }*/
}