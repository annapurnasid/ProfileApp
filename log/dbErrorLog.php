<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Error Page
 */

require_once('config/session.php');

$objSes = new session();
$objSes->start();
$resultSes = $objSes->checkSession();

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
            <img src="/images/error.png">
        </div>
        <!-- Container -->
    </body>
</html>
