<?php
/*
  @Author : Mfsi_Annapurnaa
  @purpose : Sign out php page
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config/session.php');

$obj = new session();
$obj->start();
$obj->signOut();

header('Location:login.php');

?>

