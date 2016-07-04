<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Handle listing of employee data and delete operation
 */

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
        <?php require_once('template/header.php'); ?>
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
                                    switch ($key)
                                    {
                                        case 'EmpID':
                                            $value = $i;
                                            echo $value;
                                            break;

                                        case 'Communication':
                                            $condition = ['column' => 'CommId', 'operator' => 'IN', 
                                                'val' => "($value)"];

                                            // Call the required query function
                                            $commResult = $obj->select('Communication', 
                                                'CommMedium', $condition);

                                            while ($commRow = mysqli_fetch_array($commResult, 
                                                    MYSQLI_ASSOC))
                                            {
                                               foreach ($commRow as $key => $value)
                                               {
                                                 echo $value . '<br /> ';
                                                }
                                            }
                                            break;

                                        case 'Image':
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
                                            break;

                                        default :
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