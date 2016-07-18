<?php

/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Search operation and Pagination
 */

require_once('config/queryOperation.php');

$obj = new queryOperation();
$jsonResult = array();

$name = $_POST['name'];

$order = $_POST['order'];

$pageNumber = $_POST['pageNo'];
$pageCount = $_POST['totalPage'];
$start = 0;

if (1 !== (int) $pageNumber)
{
    $start = ($pageNumber-1) * ROWPERPAGE;
}

$result = $obj->getEmployeeDetail($start, '', $order, $name);

if (!$result)
{
    errorFile('Retrival failed' . mysql_error() . time());
}

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    
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
