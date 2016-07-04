<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Common navigation bar for all pages
 */

require_once('config/session.php');

$objSes = new session();
$resultSes = $objSes->checkSession();
$loggedIn = FALSE;

if ($resultSes)
{
    $loggedIn = TRUE;
}

?>
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
<!-- Navigation -->
<nav class="navbar navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <p class="navbar-brand">GetEmpl0yed.com</p>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <?php 
            if (!$loggedIn)
            {
        ?>
                <ul class="nav navbar-nav">
                   <li>
                      <a href="index.php">Home</a>
                   </li>
                   <li>
                      <a href="registration.php">Registration</a>
                   </li>
                   <li>
                      <a href="login.php">Login</a>
                   </li>
                </ul>
        <?php 
            }
            else 
            {
        ?>
                <ul class="nav navbar-nav">
                   <li>
                      <a href="userHome.php">User Home</a>
                   </li>
                   <li>
                      <a href="list.php">Employee Data</a>
                   </li>
                   <li>
                       <a href="signOut.php">Sign Out</a>
                   </li>
                </ul>
        <?php 
            }
        ?>
    </div>
    <!-- Container -->
</nav>
