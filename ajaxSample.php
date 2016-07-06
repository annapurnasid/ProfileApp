<?php
//echo '====hello'; 
//print_r($_POST);


require_once('config/queryOperation.php');

$obj = new queryOperation();

$name = $_POST['name'];

$result = $obj->searchData($name);
if (!$result)
{
    echo 'Retrival failed' . mysql_error();
}
 
$jsonResult = array();
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
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
//echo $_POST['search'];

?>