<?php
/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Update permission for resources 
 */
require_once('config/queryOperation.php');

$obj = new queryOperation();



foreach ($_POST['permData'] as $key => $value)
{
    $permission = $obj->changePermission($key, $_POST['permData'][$key]);
}


//

?>

