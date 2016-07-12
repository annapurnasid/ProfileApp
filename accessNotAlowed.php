<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Access not allowed
 */

require_once('config/session.php');

$objSes = new session();
$objSes->start();
$resultSes = $objSes->checkSession();

if (!$resultSes)
{
    header('Location:login.php');
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
        <div class="container text-center">           
            <h3 class="primary"><b><?php echo $_SESSION['title'] . ' ' . $_SESSION['firstName'] . ' ' 
                    . $_SESSION['middleName'] . ' ' . $_SESSION['lastName']; 
                ?></b> you are not allowed to access the requested page!</h3>
        </div>
        <!-- Container -->
    </body>
</html>

