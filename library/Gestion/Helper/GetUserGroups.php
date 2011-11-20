<?php

class Gestion_View_Helper_GetUserGroups extends Zend_View_Helper_Abstract
{

    /**
     * Get groups of user
     *
     * @param string $id The user id
     * @return String containing description of all groups
     */
    function getUserGroups($id)
    {
        $userGroups = array();
        $usersRowset = new ZAP_Model_DbTable_Users();
        $user = $usersRowset->find($id)->current();
        $groups = $user->findManyToManyRowset('ZAP_Model_DbTable_Groups', 'ZAP_Model_DbTable_Privileges');
        //$groups = $groups->toArray();
       //print_r($groups);
       //die();
        foreach ($groups as $group)
        {
            $userGroups[] = $group->description;
        }

        return $userGroups;
    }


}
