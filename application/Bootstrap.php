<?php
/**
 * Fichier Bootstrap
 *
 * @author     Frederic Sheedy
 * @category   models
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function run()
    {
        $this->bootstrap('dbs');
        $dbs = $this->getPluginResource('dbs');
        $dbs->getDbAdapter('db1')->query("SET NAMES 'utf8'");
        //$dbs->getDbAdapter('db2')->query("SET NAMES 'utf8'");
        //$dbs->getDbAdapter('db3')->query("SET NAMES 'utf8'");
        
        Zend_Registry::set('db1', $dbs->getDbAdapter('db1'));
        Zend_Registry::set('db2', $dbs->getDbAdapter('db2'));
        Zend_Registry::set('db3', $dbs->getDbAdapter('db3'));
        
        $this->bootstrap('frontController');
        
        try {
            $this->frontController->dispatch();
        } catch (Exception $exception) {
            echo "<b>ERREUR FATALE</b>";
            echo "<p>!!! Vous avez tomb&eacute; sur une erreur fatale qui sera rapport&eacute;e automatiquement !!!</p>";
            echo "<pre>";
            echo "L'erreur a &eacute;t&eacute; rapport&eacute;e &agrave; l'administrateur";

            $errors = new ZAP_Model_Errors();
            $row = $errors->createRow();
            $row->date_open = date('Y-m-d H:i');
            $row->exception = $exception;
            $row->save();

            echo "</pre>";
        }
    }
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'ZAP',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
   /**
    * Fonction servant à initialiser la vue
    */
    protected function _initView()
    {
        // Initialize view
        $view = new Zend_View();
        $view->setEncoding('UTF-8');
        //$view->setEscape('htmlentities');
        $view->doctype('XHTML1_STRICT');
        $view->addHelperPath('Gestion/Helper/', 'Gestion_View_Helper');
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
         $view->addHelperPath('App/View/Helper/', 'App_View_Helper');
        //$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
        $view->addHelperPath(APPLICATION_PATH . '/../library/ZendX/JQuery/View/Helper',
                                    'ZendX_JQuery_View_Helper');

        Zend_View_Helper_PaginationControl::setZAPViewPartial('pagination.phtml');
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        ZendX_JQuery_View_Helper_JQuery::enableNoConflictMode();
    /*$view->jQuery()->uiEnable();*/
        /*Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);*/
        // Return it, so that it can be stored by the bootstrap
        return $view;
    } 




    protected function _initSecurity()
    {

    $front = Zend_Controller_Front::getInstance();
    //$front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler());
    Zend_Registry::set('acl', new ZAP_Plugin_Acl());
    $front->registerPlugin(new ZAP_Plugin_Authentification(Zend_Auth::getInstance(), Zend_Registry::get('acl')));


    }

    /*protected function _initFrontController()
    {
        $app = $this->getApplication();
        $bootstrap = $app->getBootstrap();
        $bootstrap->registerPluginResource(new Plugin_Authentification());
    }*/
    
        /*protected function _initZFDebug()
    {
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->registerNamespace('ZFDebug');
    $options = array(
        'plugins' => array('Variables', 
                  'Database' => array('adapter' => $db), 
                  'File' => array('basePath' => '/path/to/project'),
                  'Memory', 
                  'Time', 
                  'Registry', 
                  'Exception')
    );
    $debug = new ZFDebug_Controller_Plugin_Debug($options);

    $this->bootstrap('frontController');
    $frontController = $this->getResource('frontController');
    $frontController->registerPlugin($debug);
    }*/


}
