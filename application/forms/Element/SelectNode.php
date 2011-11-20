<?php

class ZAP_Form_Element_SelectNode extends Zend_Form_Element_Select {

    public function init() {
        $nodes = new ZAP_Model_NodesWifidog();
        $nodesList = $nodes->getNodesName();

        $this->setMultiOptions($nodeList);
    }
}
