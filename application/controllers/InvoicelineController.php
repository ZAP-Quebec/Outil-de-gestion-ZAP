<?php
/**
 * Invoice Controller
 *
 * @author     Frederic Sheedy
 * @category   controllers
 * @package    management
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */

/**
 * Invoice Controller Class
 *
 * @version    1.0
 * @copyright  2008 Frederic Sheedy
 * @license    GNU GPL V3
 */
class InvoicelineController extends Zend_Controller_Action {
    /**
     * Init
     */
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();

    }

    /**
     * Test
     */
    function indexAction() {
        /*$customers = new ZAP_Model_Invoices();
        $this->view->entries = $customers->fetchAll();*/
        /*$nodesWifidog = new NodesWifidog();
        $this->view->nodesWifidog = $nodesWifidog->fetchAll(null, 'name');*/
    }

    public function addAction() {
        $request = $this->getRequest();
        $form    = new ZAP_Form_InvoicesLines();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $line = new ZAP_Model_InvoicesLines($form->getValues());

                // recheche priorite (prochain numéro)
                if ($line->Order == "") {
                  $search = new ZAP_Model_InvoicesLines();
                  $reference = $this->_getParam('reference', 0);
                  $searchResults = $search->fetchByInvoiceDesc($reference);
                  if ($searchResults) {
                    foreach ($searchResults as $result) {
                      $a = intval($result->order);
                      $a = $a+1;
                      $line->Order = $a;
                      unset ($a);
                      break;
                    }
                  } else {
                    $line->Order = '0';
                  }
                }
                
                $line->Id_invoice = $this->_getParam('reference', 0);

                $result = $line->save();
                
                $log = new ZAP_Model_Log();
                $log->add($result, 'INVOICE-LINE', 'ADD', $form->getValues());
                $this->_helper->FlashMessenger('Item ajouté');
                return $this->_helper->redirector->gotoUrl('invoice/update/id/'.$line->Id_invoice);
            }
        }
        $this->view->form = $form;
    }
    
        /**
     * View customer
     */
    public function updateAction()
    {
        $request  = $this->getRequest();
        $form = new ZAP_Form_InvoicesLines();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_InvoicesLines($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_places = new ZAP_Model_InvoicesLines();
                  $oldValue = $old_places->fetchById($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'INVOICES_LINES', 'UPDATE', $form->getValues(), $oldValue);
                
                $places->save();
                $this->_helper->FlashMessenger('Item modifié');
                /*$line = new ZAP_Model_InvoicesLines();
                $line->find(id);*/
                /*print_r($oldValue);*/
                return $this->_helper->redirector->gotoUrl('invoice/update/id/'.$oldValue['id_invoice']);
            }
        }

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $lines = new ZAP_Model_InvoicesLines();
                   $form->populate($lines->fetchById($id));
                }

        $this->view->form = $form;
    }
    

    public function printAction() {
        // import the SVG XSLT
        $xsl = new XSLTProcessor();
        $xsl->importStyleSheet(DOMDocument::load("facture.xsl"));

        // load the claim data XML
        // $claim is the database result from Listing 4
        $doc = new DOMDocument();
        $doc->loadXML($invoice);

        // tell the browser this is an SVG document
        header("Content-Type: image/svg+xml");

        // print the SVG to the browser
        echo $xsl->transformToXML($doc);
    }

}