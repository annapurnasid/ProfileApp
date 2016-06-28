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
$result = $obj->getEmployeeDetail();

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
        <div class="container-fluid">
            <table class="table table-responsive">
                <tbody>
                    <tr>
                        <!-- Column headers -->
                        <th>Serial No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Office Address</th>
                        <th>Residential Address</th>
                        <th>Marital  Status</th>
                        <th>Employement Status</th>
                        <th>Employer</th>
                        <th>Communication</th>
                         <th>Image</th>
                        <th>Note</th>
                        <th>Edit</th>
                       <th>Delete</th>
                   </tr>
                    <?php
                        $i = 0;
                        // Continue till the last record 
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                        {
                           ++$i;
                    ?>
                            <tr>
                            <?php 
                                foreach ($row as $key => $value)
                                {
                            ?>
                                    <td> 
                                    <?php 
                                        if ('EmpID' === $key)
                                        {
                                           $value = $i;
                                          echo $value;
                                        }
                                        else if ('Communication' === $key)
                                        {
                                            $condition = ['column' => 'CommId', 'operator' => 'IN', 
                                                'val' => "($value)"];

                                            // Call the required query function
                                            $commResult = $obj->select('Communication', 'CommMedium',
                                                $condition);

                                            while ($commRow = mysqli_fetch_array($commResult, MYSQLI_ASSOC))
                                            {
                                               foreach ($commRow as $key => $value)
                                               {
                                                 echo $value . '<br /> ';
                                                }
                                            }
                                        }
                                        else if ('Image' === $key) 
                                        { 
                                            $imageName = IMAGEPATH . $value;

                                            if (!empty($value) && file_exists($imageName))
                                            {
                                        ?>
                                                <img src = "<?php echo $imageName;?>" alt = "No image" 
                                                    height = "50" width = "50">
                                        <?php 
                                            }
                                            else
                                            {
                                               echo 'No Image';
                                            }
                                        }
                                    else 
                                    {
                                        echo $value;
                                    }                        
                                    ?> 
                                    </td>
                                <?php 
                                    } 
                                ?>
                                    <!--Edit graphic-->
                                    <td>
                                    <?php 
                                            if ( $_SESSION['id'] === $row['EmpID'])
                                            { 
                                    ?>
                                                <a href="registration.php">
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                    <?php 
                                        
                                            } 
                                    ?>
                                    </td>
                                    <!--Delete graphic-->
                                    <td>
                                        <a href="list.php?delete=<?php echo $row['EmpID']; ?>">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                }
                            ?>
                </tbody>
            </table>
        </div>
    <!-- Container -->
    </body>
</html>