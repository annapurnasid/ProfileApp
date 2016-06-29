<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Display after login
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
        require_once('template/header.php');
        ?>
        <!-- Page Content -->
        <div class="container text-center">           
            <h1>Welcome to GetEmployed.com</h1>
            <h3 class="primary">We are glad to welcome<b><?php echo $_SESSION['title'] . ' ' . 
               $_SESSION['firstName'] . ' ' . $_SESSION['middleName'] . ' ' . $_SESSION['lastName']; 
                ?></b>
                to our family. Keep in touch and check your mailbox regularly</h3>
            <a href="registration.php" class="btn btn-default btn-lg" role="button">Update</a>
        </div>
        <!-- Container -->
    </body>
</html>