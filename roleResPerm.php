<?php
/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : ACL Operations
 */

class aclOperation
{

    /**
    * Function for checking permission 
    *
    * @access public
    * @param  string role
    * @param  string resource
    * @return void
    */
    function roleResourcePermission($role, $resource)
    {
        array_key_exists($resource, $_SESSION[$role]) ? '' : 
            header('Location:accessNotAlowed.php');
    }

    /**
    * Function for executing pagination
    *
    * @access public
    * @param  int pageCount
    * @param  int pageNo
    * @return void
    */
    function isAllowed($role, $resource)
    {
        
          $requestedAction = isset($_GET['action']) ? $_GET['action'] : '';
//        echo $requestedAction;
//        echo '<pre>';
//        print_r($_SESSION);
//        exit;

        if ('edit' === $requestedAction)
        {
            if ($_SESSION['id'] !== $_GET['edit'])
            {
                if('1' === $_SESSION['roleId'])
                {
                    return TRUE;
                }
            }
        }

        if ('1' === $_SESSION[$role][$resource][$requestedAction])
        {
            return TRUE;
        }

        header('Location:accessNotAlowed.php?isaloo');
    }
}
