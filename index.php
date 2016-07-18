<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Index page
 */

require_once('config/session.php');
$objSes = new session();

if ($objSes->checkSession())
{
    $objSes->signOut();
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
            <h1>Welcome to GetEmployed.com</h1>
            <h3 class="primary">Fill the registration form to submit your details. 
                You will get call for the best suitable job available for you.</h3>
            <a href="registration.php" class="btn btn-default btn-lg" role="button">Register</a>
        </div>
        <!-- Container -->
    </body>
</html>