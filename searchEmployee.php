<?php
/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Search employee
 */

require_once('config/queryOperation.php');

$obj = new queryOperation();

$name = $_POST['name'];

$result = $obj->searchData($name);

if (!$result)
{
    errorFile('Retrival failed' . mysql_error() . time());
}
 
$jsonResult = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
    $condition = ['column' => 'CommId', 'operator' => 'IN', 'val' => '(' . 
        $row['Communication'] . ')'];

    // Call the required query function
    $commResult = $obj->select('Communication', 'CommMedium',
        $condition);

    while ($commRow = mysqli_fetch_array($commResult, MYSQLI_ASSOC))
    {
       foreach ($commRow as $key => $value)
       {
            $row['medium'][] = $value;
        }
    }

        $row['Communication'] = $row['medium'];
        unset($row['medium']);

    $jsonResult[] = $row;
}

echo json_encode($jsonResult);