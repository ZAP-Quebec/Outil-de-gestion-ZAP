<?php

class Gestion_View_Helper_IsAllowed extends Zend_View_Helper_Abstract
{

    /**
     * Know if it's ok to show
     *
     * @param  Zend_Acl_Resource_Interface|string $resource
     * @param  string                             $privilege
     * @return boolean
     */
    function isAllowed($ressource, $privilege = null)
    {
        $user = Zend_Auth::getInstance()->getIdentity();
        $acl = Zend_Registry::get('acl');
        $groups = $user->groups;

        $access = false;
        foreach ($groups as $group)
        {
            $access = $acl->isAllowed($group, $ressource, $privilege);

            if ($access)
            {
                break;
            }
        }

        return $access;
    }


}
