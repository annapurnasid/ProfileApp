<?php

/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : handle thelisting of employee data and deletion ofrow.
 */

require_once('config/session.php');
require_once('roleResPerm.php');
require_once('config/queryOperation.php');

$objSes = new session();
$objSes->start();
$resultSes = $objSes->checkSession();

if (!$resultSes)
{
    header('Location:login.php');
}

$rrpObj = new aclOperation();

$role = $_SESSION['role'];

$resource = pathinfo($_SERVER['REQUEST_URI'])['filename'];

$rrpObj->roleResourcePermission($role, $resource);

$obj = new queryOperation();

// Total no of rows
$rowCount = $obj->countRecord();

// No of required pages
$pageCount = ceil($rowCount[0]/ROWPERPAGE);

// If total rows is < 10
if ($pageCount < 1)
{
    $pageCount = 1;
}

// To set the ascending or descending order
$sortAscend = TRUE;

// Delete a row
if (isset($_GET['delete']))
{

    if ($rrpObj->isAllowed($role, $resource))
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
}

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
                        <div class="row form-group center-block well col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 nameSearch">
                                <input id="nameSearch"  name="nameSearch" type="search" 
                                       class="form-control  input-md" placeholder="Search name">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 nameSearch">
                                <button type="button" id="searchButton" class="btn btn-info search">
                                    <span class="glyphicon glyphicon-search"></span> Search
                                </button>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                <button type="button" class="btn btn-default btn-sm" id="sortList">
                                    <span class="glyphicon glyphicon-sort-by-alphabet"></span>
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
                <ul></ul>
            </div>
        </div>
    <!-- Container -->
     <script src='js/jquery.js'></script>
    <script src="js/jsOperations.js"></script>
    <script type="text/javascript">
        id = <?php echo $_SESSION['id']; ?>;
        pageCount = <?php echo $pageCount?>;
        pageNumber = 1;
        deletePermission = <?php echo $_SESSION[$role][$resource]['remove'] ?>;
        editPermission = <?php echo $_SESSION[$role][$resource]['edit'] ?>;
        role= '<?php echo $_SESSION['role'] ?>';
        path= '<?php echo IMAGEPATH ?>';
        sortAscen = '<?php echo $sortAscend ?>';
    </script>
    </body>
</html>
