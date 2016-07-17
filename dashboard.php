<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Dashboard to display permissions
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

$role = $_SESSION['role'];

$obj = new queryOperation();

if ('admin' === $role)
{
    $permissionResult = $obj->permissionResult();

    foreach ($permissionResult as $key => $value)
    {
        unset($permissionResult[$key]['role']);
        unset($permissionResult[$key]['resource']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Get Employed</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/styles.css" rel="stylesheet">
    </head>
    <body>
        <?php
        include('template/header.php');
        ?>
        <!-- Page Content -->
        <div class="container text-center panelContainer">           

            <?php
                if ('admin' === $role)
                { ?>
                    <table class="table" align="right">
                        <thead>
                            <th></th>
                            <?php  foreach ($permissionResult['dashboard'] as $key => $value)
                            {?>
                            <th>
                             <?php echo $key ?></th><?php } ?>
                        </thead>
                        <tbody>
                        <?php foreach ($permissionResult as $key=> $value)
                            {
                                //echo $key;
                                $resource = $key;?>
                                <tr>
                                <td class="capitalize"><b><?php echo $resource?></b>
                                </td>
                                <?php
                                foreach ($permissionResult[$resource] as $key => $allowed)
                                {?>

                                <td><input type="checkbox" <?php echo ('1' === $allowed) ? 
                                "checked=checked" : '' ?> id="<?php echo $key; ?>"
                                name="<?php echo $resource?>" class="checkBox"
                                value="<?php echo $allowed; ?>"></td>
                               <?php }
                            ?>
                                </tr>
                            <?php 
                            } ?>
                        </tbody>
                        </table>
                        <div>
                            <button type="submit" class="btn btn-success" id="changePermission"
                                role="button">Submit</button>
                            <button type="reset" class="btn btn-primary" 
                                role="button">Reset</button>
                        </div>
                <?php }
                else
                { ?>
                    <div class="panel panel-primary">
                    <div class="panel-heading capitalize"><?php echo $_SESSION['role']?></div>
                    <?php foreach ($_SESSION[$role]['dashboard'] as $key => $value)
                    {
                        if ('1' === $value)
                        {
                            ?><div class=" panel panel-body capitalize"><?php echo $key?></div><?php
                        }
                    }
                    ?>
                    </div>
               <?php }
            ?>
        </div>
        <!-- Container -->
        <script src='js/jquery.js'></script>
        <script src='js/jQueryValidation.js'></script>
        <script src='js/jsOperations.js'></script>
    </body>
</html>
