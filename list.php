<?php
/*
  @Author : Mfsi_Annapurnaa
  @purpose : handle thelisting of employee data.
  : Deletion of a row
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config/session.php');
require_once('config/queryOperation.php');

$objSes = new session();
$objSes->start();
$resultSes = $objSes->checkSession();

if (!$resultSes)
{
    header('Location:login.php');
}

$obj = new queryOperation();

// Total no of rows
$rowCount = $obj->countRecord();

// Results per page
$rowPerPage = 10;

// No of required pages
$pageCount = ceil($rowCount[0]/$rowPerPage);

// If total rows is < 10
if ($pageCount < 1)
{
    $pageCount = 1;
}

// Delete a row
if (isset($_GET['delete']))
{
    $empId = $_GET['delete'];

    // Extract image name and delete it
    $condition = ['column' => 'Employee.empId', 'operator' => '=', 'val' => $empId];
    $result = $obj->select('Employee', 'image', $condition);
    $img = mysqli_fetch_array($result);

    if (file_exists($img['image']))
    {
        unlink(IMAGEPATH . $img['image']);
    }
    // Delete the address detail
    $condition = ['column' => 'Address.empId', 'operator' => '=', 'val' => $empId];
    $obj->delete('Address', $condition);

    // Delete the employee detail
    $condition = ['column' => 'Employee.empId', 'operator' => '=', 'val' => $empId];
    $obj->delete('Employee', $condition);
}

// Call the required query function
//$result = $obj->getEmployeeDetail();

$search = false;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Get Empl0yed</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/styles.css" rel="stylesheet">
    </head>
    <body>
        <?php include('template/header.php'); ?>
        <!-- Page Content -->
        <div class="container-fluid" >
       <form id="searchForm" method="POST" class="form-horizontal">
            <fieldset>
                <!-- Form Name -->
                <!-- Search input-->
                

                        <div class="row form-group center-block well col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="nameSearch">Name</label>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                            <input id="nameSearch"  name="nameSearch" type="search" class="form-control input-md">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <button type="button" id="searchButton" class="btn btn-info search">
                                <span class="glyphicon glyphicon-search"></span> Search
                            </button>
                        </div>
                        </div>
                    
            </fieldset>
        </form>
            <div class="listDisplay">
                <table class="table table-responsive" id="display">

                </table>
            </div>
            <div id="paginationControls">
                <ul>
                    
                </ul>
            </div>
        </div>
    <!-- Container -->
    
     <script src='js/jquery.js'></script>
        <script src="js/newjQuery.js"></script>
         <script type="text/javascript">
        id = <?php echo $_SESSION['id']; ?>;
        </script>
    </body>
</html>