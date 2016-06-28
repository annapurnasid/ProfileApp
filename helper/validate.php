<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Form Validation
 */

require_once('validateInput.php');
$inputData['postData'] = $_POST;
$inputData['fileData'] = $_FILES;

$title = isset($inputData['postData']['title']) ? $inputData['postData']['title'] : '';
$firstName = isset($inputData['postData']['firstName']) ? $inputData['postData']['firstName'] : '';
$middleName = isset($inputData['postData']['middleName']) ? $inputData['postData']['middleName'] : '';
$lastName = isset($inputData['postData']['lastName']) ? $inputData['postData']['lastName'] : '';
$email = isset($inputData['postData']['email']) ? $inputData['postData']['email'] : '';
$password = isset($inputData['postData']['password']) ? $inputData['postData']['password'] : '';
$confirmPassword = isset($inputData['postData']['confirm']) ? $inputData['postData']['confirm'] : '';
$gender = isset($inputData['postData']['gender']) ? $inputData['postData']['gender'] : '';
$dob = isset($inputData['postData']['dob']) ? $inputData['postData']['dob'] : '';
$phone = isset($inputData['postData']['phone']) ? $inputData['postData']['phone'] : '';
$resStreet = isset($inputData['postData']['resStreet']) ? $inputData['postData']['resStreet'] : '';
$resCity = isset($inputData['postData']['resCity']) ? $inputData['postData']['resCity'] : '';
$resZip = isset($inputData['postData']['resZip']) ? $inputData['postData']['resZip'] : '';
$resState = isset($inputData['postData']['resState']) ? $inputData['postData']['resState'] : '';
$ofcStreet = isset($inputData['postData']['ofcStreet']) ? $inputData['postData']['ofcStreet'] : '';
$ofcCity = isset($inputData['postData']['ofcCity']) ? $inputData['postData']['ofcCity'] : '';
$ofcZip = isset($inputData['postData']['ofcZip']) ? $inputData['postData']['ofcZip'] : '';
$ofcState = isset($inputData['postData']['ofcState']) ? $inputData['postData']['ofcState'] : '';
$marStatus = isset($inputData['postData']['marStatus']) ? $inputData['postData']['marStatus'] : '';
$empStatus = isset($inputData['postData']['empStatus']) ? $inputData['postData']['empStatus'] : '';
$employer = isset($inputData['postData']['employer']) ? $inputData['postData']['employer'] : '';
$communication = (isset($inputData['postData']['comm']) && !empty($inputData['postData']['comm'])) ? 
    implode(',', $inputData['postData']['comm']) : '';
$note = isset($inputData['postData']['note']) ? $inputData['postData']['note'] : '';
$update = (isset($inputData['postData']['checkUpdate']) && 1 == $inputData['postData']['checkUpdate']) 
    ? TRUE : FALSE;
$employeeIdUpdate = isset($inputData['postData']['employeeId']) ? $inputData['postData']['employeeId'] : '';

if (!$_FILES['image']['error'])
{
    // Name of uploaded file
    $name = $_FILES['image']['name']; 
}

$error = FALSE;
$valObj = new validateInput($inputData, $update);

// List of required fields
$requiredField = ['title', 'firstName', 'lastName', 'email', 'phone', 'dob', 'resStreet',
    'resCity', 'resZip', 'resState', 'marStatus', 'empStatus', 'employer', 'comm', 'image'];

// Add required fields specific to registration
if (!$update)
{
    array_push($requiredField, ['password', 'confirm']);
}

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