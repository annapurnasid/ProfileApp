<?php
/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Pagination
 */
require_once('config/queryOperation.php');

$obj = new queryOperation();

$jsonResult = array();

$pn = $_POST['pageNo'];
$pageCount = $_POST['totalPage'];
$rowPerPage = 5;
$start = 0;

if (1 !== $pn) {
    $start = $pn * $rowPerPage;
}

$result = $obj->getEmployeeDetail($start);

if (!$result)
{
    echo 'Retrival failed' . mysql_error();
}

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
    $condition = ['column' => 'CommId', 'operator' => 'IN', 'val' => '(' . $row['Communication'] . ')'];

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

$data = json_encode($jsonResult);
echo $data;
