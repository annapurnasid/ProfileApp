<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Sign out php page
 */

require_once('config/session.php');

$obj = new session();
$obj->start();
$obj->signOut();

header('Location:login.php');

