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
class InvoiceController extends Zend_Controller_Action {
    /**
     * Init
     */
    function init() {
        // Variables
        $this->view->setEncoding('utf-8');
        $this->view->setEscape('htmlentities');
        $this->view->baseUrl = $this->_request->getBaseUrl();

    }
    
    public function addAction() {
        $request = $this->getRequest();
        $id_customer = $this->_getParam('id_customer', 0);
        //die($id_customer);
        $form     = new ZAP_Form_Invoices();
        $form->setVersion('add');
        $form->setIdCustomer($id_customer);
        $form->init();
        $formLine = new ZAP_Form_InvoicesLines();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $invoice = new ZAP_Model_Invoices($form->getValues());

                $result = $invoice->save();
                
                $log = new ZAP_Model_Log();
                $log->add($result, 'INVOICE', 'ADD', $form->getValues());
                $this->_helper->FlashMessenger('Facture ajoutée');
                return $this->_helper->redirector->gotoUrl('invoice/update/id/'.$result);
            }
        }
        $form->populate(array('status'=>'Ébauche','date'=>date('Y-m-d')));

        $this->view->form = $form;
        $this->view->formLine = $formLine;
    }

    /**
     * List
     */
    function indexAction() {
        $customers = new ZAP_Model_Invoices();
        $this->view->entries = $customers->fetchAll();
        /*$nodesWifidog = new NodesWifidog();
        $this->view->nodesWifidog = $nodesWifidog->fetchAll(null, 'name');*/
    }
    
    
        public function update2Action()
    {
        $this->view->messages = ($this->_helper->flashMessenger->getMessages());
        $request  = $this->getRequest();
        $form     = new ZAP_Form_Invoices2();
        $formLine = new ZAP_Form_InvoicesLines();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Invoices($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_places = new ZAP_Model_Invoices();
                  $oldValue = $old_places->getPlace($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'INVOICES', 'UPDATE', $form->getValues(), $oldValue);
                
                $places->save();
                return $this->_helper->redirector('index');
            }
        }

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $customer = new ZAP_Model_Invoices();
                  $form->populate($customer->getInvoice($id));

                  // Lines
                  $comments = new ZAP_Model_InvoicesLines();
                  $this->view->lines = $comments->fetchByInvoice($id);
                }

        $this->view->form = $form;
        $this->view->formLine = $formLine;
    }
    
    /**
     * ajax new line
     */
    public function newlineAction()
    {
        $this->_helper->layout()->disableLayout();

    $ajaxContext = $this->_helper->getHelper('AjaxContext');
    $ajaxContext->addActionContext('newfield', 'html')->initContext();
    
    $id = $this->_getParam('line_id', null);
    
    $element = new Zend_Form_Element_Text("newName$id");
    $element->setRequired(true)->setLabel('Name');
    
    //$this->view->field = $element->__toString();
    $this->view->line = $element->__toString();
    //$this->view->line = "<p>test!</p>";

 }

    
    
        /**
     * View customer
     */
    public function updateAction()
    {
        $this->view->messages = ($this->_helper->flashMessenger->getMessages());
        $request  = $this->getRequest();
        $form     = new ZAP_Form_Invoices();
        $formLine = new ZAP_Form_InvoicesLines();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $places = new ZAP_Model_Invoices($form->getValues());

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $old_places = new ZAP_Model_Invoices();
                  $oldValue = $old_places->getInvoice($id);
                }
                
                $log = new ZAP_Model_Log();
                $log->add($id, 'INVOICES', 'UPDATE', $form->getValues(), $oldValue);
                
                $places->save();
                return $this->_helper->redirector->gotoUrl('invoice/update/id/'.$id);
            }
        }

                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                  $customer = new ZAP_Model_Invoices();
                  $customer->find($id);
                  $form->populate($customer->getInvoice($id));
                  $this->view->invoice_date = $customer->getDate();
                  // Lines
                  $comments = new ZAP_Model_InvoicesLines();
                  $this->view->lines = $comments->fetchByInvoice($id);
                }

        $this->view->form = $form;
        $this->view->formLine = $formLine;
    }
    
    /**
     * View customer
     */
    public function viewAction()
    {
        $invoice = new ZAP_Model_Invoices();
        $id = $this->_getParam('id', 0);
        $this->view->entry = $invoice->getInvoice($id);
    }

    public function printAction() {
        $this->_helper->layout->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();

        $id = $this->_getParam('id', 0);
        $invoice = new ZAP_Model_Invoices();
        $invoice->find($id);

        $customer = new ZAP_Model_Customers();
        $customer->find($invoice->id_customer);

        $invoiceLines = new ZAP_Model_InvoicesLines();
        $result = $invoiceLines->getInvoiceLines($id);

        $line_count = 0;
        $lines = '';

        $sub_total = 0;
        $currency = new Zend_Currency('fr_CA');
        foreach ($result as $line) {
            $line_count++;
            $lines .= '<description'.$line_count.'>'.$line['description'].'  ('.$line['number'].' X '.$currency->toCurrency($line['unit_price']).') </description'.$line_count.'>';
            $lines .= '<note'.$line_count.'>'.$line['note'].'</note'.$line_count.'>';
            $lines .= '<cost'.$line_count.'>'.$currency->toCurrency($line['unit_price'] * $line['number']).'</cost'.$line_count.'>';

            $sub_total = $sub_total+($line['unit_price'] * $line['number']);
        }
        
        
        //calcul taxes
        // ***********************************************************
        // TODO: faire une fonction!
        // IMPORTANT: pour le moment changer dans la vue update aussi!
        // ***********************************************************
        
        /*Janvier 2011:TVQ 5% et TPS 8.5%: http://www.revenu.gouv.qc.ca/fr/entreprise/taxes/tvq_tps/default.aspx
            2010: 5% et 7.5%
            janvier 2008: tps passe de 6 à 5%
            juillet 2006: tps passe de 7 à 6%*/
        
        $invoice_date = substr($invoice->date, 0, 4);
        
        switch ($invoice_date) {
            
            case 2005:
                $txt_tps = "TPS (7,0%)";
                $txt_tvq = "TVQ (7,5%)";
                $tps = $sub_total * 0.07;
                $tvq = ($sub_total + $tps) * 0.075;
                break;
            
            case 2006:
                $txt_tps = "TPS (6,0%)";
                $txt_tvq = "TVQ (7,5%)";
                $tps = $sub_total * 0.06;
                $tvq = ($sub_total + $tps) * 0.075;
                break;
            
            case 2007:
                $txt_tps = "TPS (6,0%)";
                $txt_tvq = "TVQ (7,5%)";
                $tps = $sub_total * 0.06;
                $tvq = ($sub_total + $tps) * 0.075;
                break;
            
            case 2008:
                $txt_tps = "TPS (5,0%)";
                $txt_tvq = "TVQ (7,5%)";
                $tps = $sub_total * 0.05;
                $tvq = ($sub_total + $tps) * 0.075;
                break;
            
            case 2009:
                $txt_tps = "TPS (5,0%)";
                $txt_tvq = "TVQ (7,5%)";
                $tps = $sub_total * 0.05;
                $tvq = ($sub_total + $tps) * 0.075;
                break;

            case 2010:
                $txt_tps = "TPS (5,0%)";
                $txt_tvq = "TVQ (7,5%)";
                $tps = $sub_total * 0.05;
                $tvq = ($sub_total + $tps) * 0.075;
                break;
            
            case 2011:
                $txt_tps = "TPS (5,0%)";
                $txt_tvq = "TVQ (8,5%)";
                $tps = $sub_total * 0.05;
                $tvq = ($sub_total + $tps) * 0.085;
                break;
                
            default:
                $txt_tps = "TPS (5,0%)";
                $txt_tvq = "TVQ (8,5%)";
                $tps = $sub_total * 0.05;
                $tvq = ($sub_total + $tps) * 0.085;
            
            
          
        }
        /*$tps = $sub_total * 0.05;
        $tvq = ($sub_total + $tps) * 0.075;*/
        
        
        $total = $sub_total + $tps + $tvq;
        // ***********************************************************
        
        // TODO change code
        if ($customer->province == 0) {
            $customer->province = "Québec";
        }
        
        //TODO: more verification
        /* "   &quot;
            '   &apos;
            <   &lt;
            >   &gt;
            &   &amp;
         */
        //$customer->name = str_replace("'", '&apos;', $customer->name);
        $customer->name = str_replace('&', '&amp;', $customer->name);

        // import the SVG XSLT
        $xsl = new XSLTProcessor();
        $xsl->importStyleSheet(DOMDocument::load("facture.xsl"));

        // load the claim data XML
        // $claim is the database result from Listing 4
        $doc = new DOMDocument();
        $doc->loadXML('<invoice>
                            <contact>'.$customer->contact_firstname.' '.$customer->contact_lastname.'</contact>
                            <customer>'.$customer->name.'</customer>
                            <address>'.$customer->address.'</address>
                            <city_province>'.$customer->city.' ('.$customer->province.')'.'</city_province>
                            <postalcode>'.$customer->postalcode.'</postalcode>

                            <id>'.$invoice->id.'</id>
                            <date>'.$invoice->date.'</date>
                            <note>'.$invoice->note.'</note>
                            <id_customer>'.$invoice->id_customer.'</id_customer>

                            '.$lines.'
                            <sub_total>'.$currency->toCurrency($sub_total).'</sub_total>
                            <tps>'.$currency->toCurrency($tps).'</tps>
                            <tvq>'.$currency->toCurrency($tvq).'</tvq>
                            <txttps>'.$txt_tps.'</txttps>
                            <txttvq>'.$txt_tvq.'</txttvq>
                            <total>'.$currency->toCurrency($total).'</total>
                            </invoice>');

        // tell the browser this is an SVG document
        //header("Content-Type: image/svg+xml");

        // print the SVG to the browser
        //echo $xsl->transformToXML($doc);

        // creation du fichier
        $svg = $xsl->transformToXML($doc);

        $fp = fopen('/var/www/demo.gestion.zapquebec.org/data/temp/'.$id.'.svg', 'w');
        fwrite($fp, $svg);
        fclose($fp);

        // conversion
        echo exec('inkscape -z --file=/var/www/demo.gestion.zapquebec.org/data/temp/'.$id.'.svg --export-pdf=/var/www/demo.gestion.zapquebec.org/data/temp/'.$id.'.pdf');

        $pdf = '/var/www/demo.gestion.zapquebec.org/data/temp/'.$id.'.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="facture'.$id.'.pdf"');
        readfile($pdf);
        
        //echo '<embed type="application/pdf" src="file:////home/fsheedy/projets/P002_Gestion/final/trunk/data/temp/'.$id.'.pdf" name="plugin" height="100%" width="100%">';


        
        /*require('svg2pdf.php');
//
//  svg affich� correstement et cal� selon sa largeur 


//
//  svg affich� correstement et cal� selon sa longueur

$mySVG2 = array (

    "filename" => "fire.svg",
    "scale_x" => 100,
    "scale_u" => "mm",
    "scale_r" => "width",
    "pos_x" => 55,
    "pos_y" => 30,
    "pos_u" => 'mm'
    
);


$pdf = new PDF_SVG('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->ImageSVG($mySVG2);
$pdf->Output();
*/
    }

}
