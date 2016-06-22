<?php

/*
  @Author : Mfsi_Annapurnaa
  @purpose : Make db connection
 */

// Including the file containing the constants
include('constants.php');

// Making connection
$conn = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBNAME);

// Checking connection
if (mysqli_connect_error($conn))
{
    die('Failed to connect to database' . mysqli_connect_error());
}

?>