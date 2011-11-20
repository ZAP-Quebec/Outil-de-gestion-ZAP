<?php

class Gestion_View_Helper_EchoCustomerStatus extends Zend_View_Helper_Abstract {

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $status Customer status
     */
    function echoCustomerStatus($status) {
        switch ($status) {
            case 1:
                $text = 'Succès';
                break;
            case 2:
                $text = 'Échec';
                break;
            default:
                $text = '';
                break;
        }

        return $text;
    }


}
