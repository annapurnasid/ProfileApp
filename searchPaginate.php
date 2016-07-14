<?php
/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Search operation and Pagination
 */
require_once('config/queryOperation.php');

$obj = new queryOperation();
$jsonResult = array();

$action = $_POST['action'];

switch ($action)
{
    case 'search':
        $name = $_POST['name'];
        $result = $obj->searchData($name);
        break;
    
    case 'pagination':
        $pn = $_POST['pageNo'];
        $pageCount = $_POST['totalPage'];
        $start = 0;

        if (1 !== (int) $pn) {
            $start = ($pn-1) * ROWPERPAGE;
        }

        $result = $obj->getEmployeeDetail($start);
        break;
}

if (!$result)
{
    errorFile('Retrival failed' . mysql_error() . time());
}

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
    $condition = ['column' => 'CommId', 'operator' => 'IN', 'val' => '(' . 
        $row['Communication'] . ')'];

    // Call the required query function
    $commResult = $obj->select('Communication', 'CommMedium',
        $condition);

    while ($commRow = mysqli_fetch_array($commResult, MYSQLI_ASSOC)) {
       foreach ($commRow as $key => $value) {
            $row['medium'][] = $value;
        }
    }
    
    $row['Communication'] = $row['medium'];
    unset($row['medium']);
    $jsonResult[] = $row;
}

echo json_encode($jsonResult);
