<?php

/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Registration form layout and Update operaton on the emplolyee data
 */
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config/queryOperation.php');
require_once('roleResPerm.php');
require_once('config/session.php');

$obj = new queryOperation();
$objSes = new session();
$objSes->start();
$result = $objSes->checkSession();

$rrpObj = new aclOperation();

if (!$result)
{
    $update = FALSE;
}
else
{
    $update = TRUE;

    $resource = pathinfo($_SERVER['REQUEST_URI'])['filename'];
    $role = $_SESSION['role'];
    $rrpObj->isAllowed($role, $resource);

    $empId = 'admin' === $_SESSION['role'] ?  $_GET['edit'] : $_SESSION['id'];
   
    $result = $obj->getEmployeeDetail($update, $empId);
    
    if (!$result)
    {
        echo 'Retrival failed' . mysql_error();
    }
    
    $row = mysqli_fetch_assoc($result);
}

$stateList = array('Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam',
    'Bihar', 'Chandigar', 'Chhattisgarh', 'Dadra and Nagar Haveli', 'Daman and Diu', 'Delhi', 'Goa',
    'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka',
    'Kerala', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram',
    'Nagaland', 'Orissa', 'Pondicherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Tripura',
    'Uttaranchal', 'Uttar Pradesh', 'West Bengal');

if (!empty($_POST))
{
    // Include validate file
    include('helper/validate.php');

    if (!$error)
    {
        // Create employee data for insert/update
        $empData = ['title' => $title, 'firstName' => $firstName, 'middleName' => $middleName,
            'lastName' => $lastName, 'dateOfBirth' => $dob, 'gender' => $gender, 'phone' => $phone,
            'email' => $email, 'maritalStatus' => $marStatus, 'empStatus' => $empStatus,
            'commId' => $communication, 'image' => $name, 'note' => $note, 'employer' => $employer];

        if ($update)
        {
            // Query for employee details
            $condition = ['column' => 'empId',
                'operator' => '=',
                'val' => $employeeIdUpdate];
            $obj->insertUpdate('Employee', $empData, $condition, TRUE);

            // Query for Office address details
            $empOfcData = ['street' => $ofcStreet, 'city' => $ofcCity,
                'zip' => $ofcZip, 'state' => $ofcState];
            $condition = ['column' => 'empId', 'operator' => '=',
                'val' => "'$employeeIdUpdate' AND addressType = 'office'"];
            $obj->insertUpdate('Address', $empOfcData, $condition, TRUE);

            // Query for Residential address details
            $empResData = ['street' => $resStreet,
                'city' => $resCity,
                'zip' => $resZip,
                'state' => $resState];
            $condition = ['column' => 'empId',
                'operator' => '=',
                'val' => "'$employeeIdUpdate' AND addressType = 'residence'"];
            $obj->insertUpdate('Address', $empResData, $condition, TRUE);

            //Redirect User to Employee List Page
            header('Location:list.php');
        }
        else
        {
            $empData['password'] = $password;

            // Insert data
            $employeeId = $obj->insertUpdate('Employee', $empData);

            // Insert office address detail
            $empOfcData = array('addressType' => 'office', 'street' => $ofcStreet,
                'city' => $ofcCity, 'zip' => $ofcZip, 'state' => $ofcState, 'empId' => $employeeId);
            $obj->insertUpdate('Address', $empOfcData);

            // Insert residence address detail
            $empResData = array('addressType' => 'residence', 'street' => $resStreet,
                'city' => $resCity, 'zip' => $resZip, 'state' => $resState, 'empId' => $employeeId);
            $obj->insertUpdate('Address', $empResData);
            header('Location:login.php?success=1');
        }
    }
}
else
{
    $errorList = array('title' => '', 'firstName' => '', 'middleName' => '',
        'lastName' => '', 'email' => '', 'phone' => '', 'gender' => '', 'dob' => '',
        'resStreet' => '', 'resCity' => '', 'resZip' => '', 'resState' => '', 'ofcZip' => '',
        'marStatus' => '', 'empStatus' => '', 'employer' => '', 'comm' => '', 'confirm' => '',
        'password' => '', 'note' => '', 'image' => '', 'dob' => '');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php 
           // If the form is for updating
           if ($update)
           {
           ?>
        <title>Update Form</title>
        <?php
           }
           else
           {// If it is a new registration form
           ?>
        <title>Registration Form</title>
        <?php
           }
           ?>  
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/styles.css" rel="stylesheet">
    </head>
   <body>
    <?php include('template/header.php')?>
    <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form id="registrationForm" action="registration.php<?php echo ($update) ? 
                        '?edit=' . $row['empId']: '';?>" method="POST" class="form-horizontal" 
                        enctype="multipart/form-data">
                        <fieldset>
                            <!-- Form Name-->
                            <?php 
                                // If the form is for updating
                                if ($update)
                                {
                            ?>
                            <h1>Update Form</h1>
                            <?php
                               }
                               else
                               {// If it is a new registration form
                            ?>
                            <h1>Registration Form</h1>
                            <?php
                                }
                            ?>                     
                            <div class="well">
                                <h3>Personal Details</h3>
                                <!-- Hidden fields to fetch flag value and employee id -->
                                <input type="hidden" name="checkUpdate" id="checkUpdate"
                                       value="<?php echo $update; ?>">
                                <input type="hidden" name="employeeId" id="checkUpdate"
                                       value="<?php echo ($update) ? $row['empId'] : FALSE; ?>">
                                <!-- Fields for name-->
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">Name</label>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <!-- Check and assign the value if it is new or update form -->
                                         <input type="text" name = "title" class="form-control required alphabets"
                                             id="inputTitle" placeholder="Mr/Ms"
                                             value="<?php echo ($update) ? $row['title'] : 
                                             (isset($_POST['title']) ? $_POST['title'] : ''); ?>">
                                        <span id="inputTitleErr" class="error"><?php 
                                        echo $errorList['title'];?></span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" name = "firstName" 
                                               class="form-control required alphabets" 
                                            id="inputFirstName" placeholder="First Name" 
                                            value="<?php echo ($update) ? $row['firstName'] : 
                                            (isset($_POST['firstName']) ? $_POST['firstName'] : ''); 
                                            ?>">
                                        <span id="inputFirstNameErr" class="error"><?php 
                                        echo $errorList['firstName'];?>
                                        </span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" name = "middleName" class="form-control alphabets" 
                                            id="inputMiddleName" placeholder="Middle Name" 
                                            value="<?php echo ($update) ? $row['middleName'] : (isset
                                            ($_POST['middleName']) ? $_POST['middleName'] : ''); ?>">
                                        <span id="inputMiddleNameErr" class="error"><?php 
                                            echo $errorList['middleName'];?></span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" name = "lastName" class="form-control required alphabets" 
                                            id="inputLastName" placeholder="Last Name" value="<?php 
                                            echo ($update) ? $row['lastName'] : (isset($_POST
                                            ['lastName']) ? $_POST['lastName'] : ''); ?>">
                                        <span id="inputLastNameErr" class="error"><?php 
                                            echo $errorList['lastName'];?></span>
                                    </div>
                                </div>
                                <!-- Email input-->
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " 
                                           for="textinput">Email</label>  
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and assign the value if it is new or update form -->
                                        <input id="inputEmail" name="email" type="text" <?php 
                                            echo ($update) ? 'readonly' : ''; ?> 
                                            placeholder="name@email.com" class="form-control required
                                            input-md" value="<?php echo ($update) ? $row['email'] : 
                                            (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
                                        <span id="inputEmailErr" class="error"><?php 
                                            echo $errorList['email'];?></span>
                                    </div>
                                </div>
                                <?php if (!$update)
                                { ?>
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                           for="textinput">Password</label>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and assign the value if it is new or update form -->
                                        <input type="password" id="inputPassword" name="password" 
                                            placeholder="********" class="form-control required password
                                            input-md">
                                        <span id="inputPasswordErr" class="error"><?php 
                                            echo $errorList['password'];?></span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                           for="textinput">Confirm Password</label>  
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and assign the value if it is new or update form -->
                                        <input type="password" id="inputConfirm" name="confirm" 
                                            placeholder="********" class="form-control password 
                                            required input-md">
                                        <span id="inputConfirmErr" class="error"><?php 
                                            echo $errorList['confirm'];?></span>
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- Phone number input-->
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " 
                                           for="number">Mobile</label>  
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and assign the value if it is new or update form -->
                                        <input id="inputPhone" name="phone" type="text" 
                                            placeholder="9999999999" class="form-control number required input-md" 
                                            value="<?php echo ($update) ? $row['phone'] : 
                                            (isset($_POST['phone']) ? $inputData['postData']['phone']
                                            : ''); ?>">
                                        <span id="inputPhoneErr" class="error"><?php 
                                            echo $errorList['phone'];?></span>
                                    </div>
                                </div>
                                 <!--Radio button for gender-->
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " 
                                        for="gender">Gender</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline" for="gender-0">
                                            <!-- Check, select the radio button for new or update -->
                                            <input type="radio" name="gender" id="gender-0" 
                                                value="male" <?php echo ($update) ? ($row['gender'] 
                                                == 'male' ? "checked=checked" : '') : 
                                                "checked=checked" ;?> >Male
                                        </label>
                                        <label class="radio-inline" for="gender-1">
                                            <input type="radio" name="gender" id="gender-1" 
                                                value="female" <?php echo ($update) ? 
                                                ($row['gender'] == 'female' ? "checked=checked" : 
                                                '') : ((isset($_POST['gender']) && 'female' == 
                                                $_POST['gender']) ? "checked=checked" : '');?>>Female
                                        </label> 
                                        <label class="radio-inline" for="gender-2">
                                            <input type="radio" name="gender" id="gender-2" 
                                                value="others" <?php echo ($update) ? 
                                                ($row['gender'] == 'others' ? "checked=checked" : '') : 
                                                ((isset($_POST['gender']) && 'others' == 
                                                $_POST['gender']) ? "checked=checked" : '');?>>Others
                                        </label>
                                    </div>
                                </div>
                                <!--Date picker for DOB-->
                                <div class="row form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">D.O.B</label>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and assign the value if it is new or update form -->
                                        <input id="inputDob" type='date' name="dob" class="form-control required"
                                            value="<?php echo ($update) ? $row['dateOfBirth'] : 
                                            (isset($_POST['dob']) ? $_POST['dob'] : ''); ?>"/>
                                        <span id="inputDobErr" class="error"><?php 
                                            echo $errorList['dob'];?></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="well">
                                <h3>Address Details</h3>
                                <!-- Address input-->
                                <!-- Resident Address-->
                                <div class="row form-group address">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="Address">Residence Address</label> 
                                        <!-- Check and assign the value if it is new or update form -->
                                        <!-- Street Name-->
                                        <input id="inputResStreet" name="resStreet" type="text" 
                                            placeholder="Street" class="form-control input-md required
                                            address" value="<?php  echo ($update) ? 
                                            $row['resStreet'] : (isset($_POST['resStreet']) ? 
                                            $_POST['resStreet'] : '');?>">
                                        <span id="inputResStreetErr" class="error"><?php echo $errorList['resStreet'];?>
                                        </span>
                                        <!-- City-->
                                        <input id="inputResCity" name="resCity" type="text" 
                                            placeholder="city" class="form-control input-md required
                                            address" value="<?php echo ($update) ? $row['resCity'] :
                                            (isset($_POST['resCity']) ? $_POST['resCity'] : '');?>">
                                        <span id="inputResCityErr" class="error"><?php 
                                            echo $errorList['resCity'];?></span>
                                        <!-- ZIp -->
                                        <input id="inputResZip" name="resZip" type="text" 
                                            placeholder="Zip" class="form-control number required input-md address" 
                                            value="<?php echo ($update) ? $row['resZip'] : 
                                            (isset($_POST['resZip']) ? $_POST['resZip'] : '');?>">
                                        <span id="inputResZipErr" class="error"><?php 
                                            echo $errorList['resZip'];?></span>
                                        <!-- Select State -->
                                        <select id="inputResState" name="resState" class="form-control required
                                            address">
                                            <option value="0">Select State</option>
                                            <?php 
                                               foreach($stateList as $key => $item)
                                                {
                                            ?>
                                                    <option value = "<?php echo $item ?>" <?php echo 
                                                        ($update && $item == $row['resState']) ? 
                                                        'selected' : ((isset($_POST['resState']) && 
                                                        $item == $_POST['resState'])? 'selected' : 
                                                        ''); ?> ><?php echo $item ?>
                                                    </option>
                                            <?php 
                                                } 
                                            ?>
                                        </select>
                                        <span id="inputResStateErr" class="error"><?php 
                                            echo $errorList['resState'];?></span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="Address">Office Address</label>
                                        <!-- Check and assign the value if it is new or update form -->
                                        <!--Street Name-->
                                        <input id="ofcStreet" name="ofcStreet" type="text" 
                                            placeholder="Street" class="form-control input-md 
                                            address" value= "<?php echo ($update) ? 
                                            $row['ofcStreet'] : (isset($_POST['ofcStreet']) ? 
                                            $_POST['ofcStreet'] : '');?>">
                                        <!-- City-->                          
                                        <input id="OfcCity" name="ofcCity" type="text" 
                                            placeholder="city" class="form-control input-md address" 
                                            value= "<?php echo ($update) ? $row['ofcCity'] : 
                                            (isset($_POST['ofcCity']) ? $_POST['ofcCity'] : '');?>">
                                        <!-- Zip-->
                                        <input id="inputOfcZip" name="ofcZip" type="text" 
                                            placeholder="Zip" class="form-control number input-md address" 
                                            value= "<?php echo ($update) ? $row['ofcZip'] : 
                                            (isset($_POST['ofcZip']) ? $_POST['ofcZip'] : '');?>">
                                        <span id="inputOfcZipErr" class="error"><?php echo $errorList['ofcZip'];?>
                                        </span>
                                        <!-- Select State -->
                                        <select id="ofcState" name="ofcState" class="form-control
                                             address">
                                            <option value="0">Select State</option>
                                            <?php 
                                                foreach($stateList as $key => $item)
                                                {
                                            ?>
                                                    <option value = "<?php echo $item ?>" <?php echo 
                                                        ($update && $item == $row['ofcState']) ? 
                                                        'selected' : ((isset($_POST['ofcState']) && 
                                                        $item == $_POST['ofcState']) ? 
                                                        'selected' : ''); ?>><?php echo $item ?>
                                                    </option>
                                            <?php 
                                               } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="well">
                               <h3>Other Details</h3>
                               <!-- Marital Status-->
                                <div class="form-group">
                                    <label class= "col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                        for="marStatus">Marital Status</label>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and select from drop down if it is new or update form -->
                                        <select id="inputMarStatus" name="marStatus" 
                                            class="form-control required" >
                                            <option value="0">Status</option>
                                            <option value="single" <?php echo ($update && 
                                                'married' == $row['marStatus']) ? 'selected' : 
                                                (((isset($_POST['marStatus']) && 'married' == 
                                                $_POST['marStatus']) ? 'selected' : '')); ?>>Single
                                            </option>
                                            <option value="married" <?php echo ($update && 
                                                'married' == $row['marStatus']) ? 'selected' : 
                                                (((isset($_POST['marStatus']) && 'married' == 
                                                $_POST['marStatus']) ? 'selected' : '')); ?>>Married
                                            </option>
                                            <option value="divorced" <?php echo ($update && 
                                                'divorced' == $row['marStatus']) ? 'selected' : 
                                                (((isset($_POST['marStatus']) && 'divorced' == 
                                                $_POST['marStatus']) ? 'selected' : '')); ?>>Divorced
                                            </option>
                                            <option value="widow" <?php echo ($update && 'widow' == 
                                                $row['marStatus']) ? 'selected' : (((isset
                                                ($_POST['marStatus']) && 'widow' == $_POST['marStatus']) 
                                                ? 'selected' : '')); ?>>Widow
                                            </option>
                                            <option value="widower" <?php echo ($update && 
                                                'widower' == $row['marStatus']) ? 'selected' : 
                                                (((isset($_POST['marStatus']) && 'widower' == 
                                                $_POST['marStatus']) ? 'selected' : '')); ?>>Widower
                                            </option>
                                        </select>
                                        <span id="inputMarStatusErr" class="error"><?php 
                                            echo $errorList['marStatus'];?></span>
                                    </div>
                                </div>
                                <!-- Radio button for employment status-->
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                        for="empStatus">Employment Status</label>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="row">
                                            <!-- Check, select the radio button if, new or update-->
                                            <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label><input id="employed" type="radio" 
                                                    name="empStatus" value="employed" <?php echo 
                                                    ($update) ? ($row['empStatus'] == 'employed' ? 
                                                    "checked=checked" : '') : "checked=checked";?>>
                                                    Employed
                                                </label>
                                            </div>
                                            <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>
                                                    <input type="radio" name="empStatus" 
                                                        value="unemployed" <?php echo ($update) ? 
                                                        ($row['empStatus'] == 'unemployed' ? 
                                                        "checked=checked" : '') : ((isset($_POST
                                                        ['empStatus']) && 'unemployed' == $_POST
                                                        ['empStatus']) ? "checked=checked" : '');?>>
                                                    Unemployed
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>
                                                    <input id="selfEmployed" type="radio" 
                                                        name="empStatus" value="self-employed" 
                                                        <?php echo ($update) ?($row['empStatus'] == 
                                                        'self-employed' ? "checked=checked" : '') : 
                                                        ((isset($_POST['empStatus']) && 
                                                        'self-employed' == $_POST['empStatus']) ? 
                                                        "checked=checked" : ''); ?>>Self-Employed
                                                </label>
                                            </div>
                                            <div class="radio col-lg- col-md-6 col-sm-6 col-xs-12">
                                               <label>
                                                   <input type="radio" name="empStatus" 
                                                        value="student" <?php echo ($update) ? 
                                                        ($row['empStatus'] == 'student' ? 
                                                        "checked=checked" : '') : ((isset($_POST
                                                        ['empStatus']) && 'student' == $_POST
                                                        ['empStatus']) ? "checked=checked" : ''); ?>>
                                                   Student
                                               </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                        for="textinput">Employer
                                    </label>  
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <!-- Check and assign value if it is new or update form -->
                                        <input id="inputEmployer" name="employer" type="text" 
                                            class="form-control input-md" value=" <?php echo 
                                            ($update) ? $row['employer'] : (isset($_POST['employer']) ? 
                                            $inputData['postData']['employer'] : ''); ?> ">
                                        <span id="employErr" class="error"><?php echo 
                                            $errorList['employer'];?></span>
                                    </div>
                                </div>
                                <!-- Image Upload -->
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                        for="textinput">Upload Image
                                    </label> 
                                    <input type="file" name="image"  value="<?php echo ($update) ? 
                                        $row['image'] : (isset($_POST['image']) ? $_POST['image'] : 
                                        ''); ?>" />
                                    <?php
                                        if ($update && isset($row['image']) && !empty($row['image'])
                                                && file_exists(IMAGEPATH . $row['image']))
                                        {
                                    ?>
                                            <!-- Modal -->
                                            <a href="" data-target="#empImage" data-toggle="modal">
                                                Current Picture</a>
                                            <div id="empImage" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                           <h4 class="modal-title">Your Image</h4>
                                                        </div>
                                                        <div class = "modal-body">
                                                            <img src = "<?php echo IMAGEPATH.
                                                                ($update ? $row['image'] : (isset
                                                                ($_POST['image']) ? $_POST['image'] 
                                                                : '')); ?>" alt = "No image" 
                                                                height = "300" width = "500">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn 
                                                                btn-default" data-dismiss="modal">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                    <span class="error"><?php echo $errorList['image'];?></span>
                                </div>
                                <!-- Communication Medium -->
                                <?php $communicationIds = isset($row['commId']) ? 
                                    explode(',', $row['commId']) : []; ?>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" 
                                        for="Communication">Communicate via
                                    </label>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="row">
                                            <!-- Check and select check box if it is new or update form -->
                                            <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="Communication-0">
                                                    <input type="checkbox" name="comm[]" 
                                                        id="inputComm0" value="1" <?php echo 
                                                        ($update) ? (in_array('1', $communicationIds) ? 
                                                        "checked=checked" : '') : ((isset($_POST['comm']) 
                                                        && !empty($_POST['comm']) && in_array('1', 
                                                        $_POST['comm'])) ? "checked=checked" : '' );?>>
                                                    E-Mail
                                                </label>
                                            </div>
                                            <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                               <label for="Communication-1">
                                                    <input type="checkbox" name="comm[]" 
                                                        id="inputComm1" value="2" <?php echo 
                                                        ($update) ? (in_array('2', $communicationIds) ? 
                                                        "checked=checked" : '') : ((isset($_POST['comm']) 
                                                        && !empty($_POST['comm']) && in_array('2', 
                                                        $_POST['comm'])) ? "checked=checked" : '' );?>>
                                                    Message
                                               </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                               <label for="Communication-2">
                                                    <input type="checkbox" name="comm[]" 
                                                        id="inputComm2" value="3" <?php echo 
                                                        ($update) ? (in_array('3', $communicationIds) ? 
                                                        "checked=checked" : '') : ((isset($_POST['comm']) 
                                                        && !empty($_POST['comm']) && in_array('3', 
                                                        $_POST['comm'])) ? "checked=checked" : '' );?>>
                                                    Phone
                                               </label>
                                            </div>
                                            <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="Communication-3">
                                                    <input type="checkbox" name="comm[]" 
                                                        id="inputComm3" value="4" <?php echo 
                                                        ($update) ? (in_array('4', $communicationIds) ? 
                                                        "checked=checked" : '') : ((isset($_POST['comm']) 
                                                        && !empty($_POST['comm']) && in_array('4', 
                                                        $_POST['comm'])) ? "checked=checked" : '' );?>>
                                                    Any
                                                </label>
                                            </div>
                                            <span id="commErr" class="error"><?php echo 
                                                $errorList['comm'];?></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Text Area -->
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Note">
                                        Note</label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <!-- check and display note if it is new or update form -->                  
                                        <textarea class="form-control" id="Note" name="note" rows="6" 
                                            placeholder="Write something about yourself"><?php echo 
                                            ($update) ? $row['note'] :(isset($_POST['note']) ? 
                                            $_POST['note'] : ''); ?>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <?php 
                                        if ($update)
                                        {
                                    // If update form, update and clear button
                                    ?>
                                        <button type="submit" class="btn btn-success" role="button">
                                            Update</button>
                                        <button type="reset" class="btn btn-primary" role="button">
                                            Clear</button> 
                                    <?php
                                        }
                                        else
                                        {
                                        // If new form, submit and reset button
                                    ?>
                                        <button id="register" type="submit" class="btn btn-success" 
                                            role="button">Submit</button>
                                        <button id="formReset" type="reset" class="btn btn-primary" 
                                                role="button">Reset</button>
                                   <?php
                                      }
                                    ?> 
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- Container -->
        <!-- Bootstrap Core JavaScript -->	
        <script src='js/jquery.js'></script>
        <script src='js/jQueryValidation.js'></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

