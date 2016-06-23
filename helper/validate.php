<?php
/*
      @Author : Mfsi_Annapurnaa
      @purpose : Form Validation
*/
    $inputData = $_POST;
    require_once('validateInput.php');
    
    $valObj = new validateInput($inputData);
    

    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
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
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $communication = (isset($_POST['comm']) && !empty($_POST['comm'])) ? implode(", ", $_POST['comm']) : '';
    $note = isset($_POST['note']) ? $_POST['note'] : '';
    $update = (isset($_POST['checkUpdate']) && 1 == $_POST['checkUpdate']) ? TRUE : FALSE;
    $employeeIdUpdate = isset($_POST['employeeId']) ? $_POST['employeeId'] : '';

    $error = FALSE;

// Image upload and image validation
    if(!$_FILES['image']['error']) 
    {
        $name = $_FILES['image']['name']; //file name uploaded
        $imageSize = $_FILES['image']['size'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageExt = $_FILES['image']['type'];

        // Image file type validation
        $exploded = explode('.',$_FILES['image']['name']);
        $imageExt =strtolower(end($exploded));
        $extensions = array('jpeg', 'jpg', 'png');


        // Move image to desired folder
        if(isset($name) && !empty($name))
        {
            move_uploaded_file($imageTmp, IMAGEPATH.$name);
        }
    }
    
    $requiredField = ['title', 'firstName', 'lastName', 'email','phone','dob', 'resStreet', 'comm','employer', 
        'resCity', 'resZip', 'resState', 'marStatus', 'empStatus', 'image'];
    
    $errorList = $valObj->required($requiredField);
    foreach ($errorList as $key => $value)
    {
        if ('' !== $value)
        {
            $error = TRUE;
            break;
        }
    }
    
?>