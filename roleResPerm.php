<?php
/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : ACL Operations
 */

class aclOperation{

    function roleResourcePermission($role, $resource) {

        

        array_key_exists($resource, $_SESSION[$role]) ? '' : header('Location:accessNotAlowed.php');
    }

    function isAllowed($requestedAction, $role, $resource) {

        if ('1' === $_SESSION[$role][$resource][$requestedAction]) {
            return TRUE;
        }
        header('Location:accessNotAlowed.php');
    }
}
