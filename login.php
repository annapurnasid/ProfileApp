<?php

/**
 * @Author : Mfsi_Annapurnaa
 * @purpose : Login page
 */

require_once('config/queryOperation.php');
require_once('config/session.php');

$obj = new queryOperation();
$error = FALSE;

if (!empty($_POST))
{
    if (!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $condition = ['column' => 'Employee.email', 'operator' => '=', 
            'val' => '\'' . $email . '\''];
        
        // Select the fields for display in userHome page
        $result = $obj->select('Employee', 'email, empId, password, title, firstName, lastName, '
            . 'middleName', $condition);
        $row = mysqli_fetch_assoc($result);
        
        if ($password !== $row['password'])
        {
            $error = 'Invalid username or password';
        }
        else
        {
            $objSes = new session();
            $objSes->start();
            $objSes->init('id', $row['empId']);
            $objSes->init('title', $row['title']);
            $objSes->init('firstName', $row['firstName']);
            $objSes->init('middleName', $row['middleName']);
            $objSes->init('lastName', $row['lastName']);
            header('Location:userHome.php');
        } 
    }
    else
    {
        $error = 'Enter username and password';
    }
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
      <title>Get Empl0yed</title>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="css/styles.css" rel="stylesheet">
   </head>
   <body>
        <?php include('template/header.php'); ?>
        <!-- Page Content -->
        <div class="container">
            <fieldset>
                <?php session_start();?>
                <div><b> 
                    <h3><?php echo isset($_SESSION['insert']) ? 'Registration Successful!' : ''; 
                                unset($_SESSION['insert']); ?></h3>
                    <b>
                </div>
                <form class="form-horizontal" action="login.php" method="POST" 
                    enctype="multipart/form-data">

                  <!-- Text input-->
                  <div class="form-group">
                     <label class="col-md-4 control-label" for="email">Username</label>  
                     <div class="col-md-4">
                        <input id="email" name="email" type="text" placeholder="xyz@gmail.com" 
                            class="form-control input-md"
                               value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                     </div>
                  </div>
                  <!-- Password input-->
                  <div class="form-group">
                     <label class="col-md-4 control-label" for="password">Password</label>
                     <div class="col-md-4">
                        <input id="password" name="password" type="password" placeholder="********" 
                            class="form-control input-md" value="<?php echo 
                            isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                        <span class="error"><?php echo $error;?></span>
                     </div>
                  </div>
                  <div class="row text-center">
                          <button class = "btn btn-lg btn-primary" type = "submit">Login</button>
                    </div>
                </form>
            </fieldset>
        </div>
   </body>
</html>
