<?php
/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Update permission for resources 
 */
require_once('config/queryOperation.php');

$obj = new queryOperation();

print_r($_POST);

foreach ($_POST['permData'] as $key => $value)
    {
        unset($_POST['permData'][$key]['resourceId']);
    }
    
print_r($_POST);

?>

