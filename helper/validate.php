<?php

/*
  @Author : Mfsi_Annapurnaa
  @purpose : Form Validation
 */
$inputData['postData'] = $_POST;
$inputData['fileData'] = $_FILES;
require_once('validateInput.php');

$title = isset($_POST['title']) ? $_POST['title'] : '';
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirm']) ? $_POST['confirm'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$resStreet = isset($_POST['resStreet']) ? $_POST['resStreet'] : '';
$resCity = isset($_POST['resCity']) ? $_POST['resCity'] : '';
$resZip = isset($_POST['resZip']) ? $_POST['resZip'] : '';
$resState = isset($_POST['resState']) ? $_POST['resState'] : '';
$ofcStreet = isset($_POST['ofcStreet']) ? $_POST['ofcStreet'] : '';
$ofcCity = isset($_POST['ofcCity']) ? $_POST['ofcCity'] : '';
$ofcZip = isset($_POST['ofcZip']) ? $_POST['ofcZip'] : '';
$ofcState = isset($_POST['ofcState']) ? $_POST['ofcState'] : '';
$marStatus = isset($_POST['marStatus']) ? $_POST['marStatus'] : '';
$empStatus = isset($_POST['empStatus']) ? $_POST['empStatus'] : '';
$employer = isset($_POST['employer']) ? $_POST['employer'] : '';
$communication = (isset($_POST['comm']) && !empty($_POST['comm'])) ? implode(", ", $_POST['comm']) : '';
$note = isset($_POST['note']) ? $_POST['note'] : '';
$update = (isset($_POST['checkUpdate']) && 1 == $_POST['checkUpdate']) ? TRUE : FALSE;
$employeeIdUpdate = isset($_POST['employeeId']) ? $_POST['employeeId'] : '';

if (!$_FILES['image']['error'])
{
    $name = $_FILES['image']['name']; //file name uploaded
}
$error = FALSE;
$valObj = new validateInput($inputData, $update);

// List of required fields
$requiredField = ['title', 'firstName', 'lastName', 'email', 'phone', 'dob', 'resStreet', 'password', 'confirm',
    'resCity', 'resZip', 'resState', 'marStatus', 'empStatus', 'employer', 'comm', 'image'];

// Error list after validation
$errorList = $valObj->required($requiredField);

// Check if there is atleast one error in list
foreach ($errorList as $key => $value)
{
    if ('' !== $value)
    {
        $error = TRUE;
        break;
    }
}
?>