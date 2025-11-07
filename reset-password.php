<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styled.css">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->

    <script src='assets/ass/jquery-3.0.0.js' type='text/javascript'></script>
    <link href="assets/ass/cropper.css" rel="stylesheet"/>
    
    <script src="assets/ass/cropper.js"></script>

    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>


<?php 
require_once 'config/config.php';
require_once 'config/pdo_db.php';
require_once('Models/User.php');

$user = new User();


?>

<?php

if (!isset($_GET['token'])) {
 redirect("error-404");			
}
$msg = "";
$token = $_GET['token'];

// $getEmail = mysqli_query($connection, "SELECT email FROM forgot_password WHERE token = '{$token}' ");
// $row = mysqli_fetch_array($getEmail);
$getEmail = $user->getForget_password($token);

foreach ($getEmail as $row) {
$mail = $row->email; 		
}

if ($user->CountForget_password($token) == 0) {
$user->redirect("error-404");		
}
date_default_timezone_set("Africa/Lagos");
$sqli =  "SELECT TIMESTAMPDIFF (SECOND, created_at, NOW()) As tdif FROM forgot_password WHERE token = '{$token}'";
$result = $connection->prepare($sqli);
$result->execute();
$result->store_result();
$result->bind_result($tdif);
$result->fetch();

if ($tdif >= 900){
	// $removeQuery = $connection->query("DELETE FROM forgot_password WHERE token = '{$token}'");
	 $removeQuery =	$user->removeforgottentoken($token);
	 $user->redirect("session_time_out");			

}

if(isset($_POST['reset'])){
	
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	// validation

	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if (empty($password)) {
		$msg = "<p class='alert alert-danger alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Invalid email address enter a valid email address!</p>";
	}elseif(strlen($password) < 8) {
		$msg = "<p class='alert alert-danger alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Password must be 8 characters in length</p>";
	}else{
		$password = password_hash($password, PASSWORD_BCRYPT);
		// $query = mysqli_query($connection, "UPDATE users SET password = '{$password}' WHERE email = '{$mail}' ");
		$query = $user->updatepassword($password,$mail);
		if ($query) {
		// $Query = $connection->query("DELETE FROM forgot_password WHERE token = '{$token}'");
			$Query = $user->removeforgottentoken($token);
		$msg = "<p class='alert alert-success alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Password Updated Successfully! <a class='loginHome' href='login'> Click to login</p>";
		}

		else{
			$msg = "<p class='alert alert-danger alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Something went wrong contact admin</p>";
		}

	}

}


?>

<body>
    <div class="main-wrapper account-wrapper rollIn">
        <div class="account-page">
			<div class="account-center">
				<div class="account-box">
                    <form action="" method="post" enctype="multipart/form-data" class="form-signin">
						<div class="account-logo">
                            <!-- <a href="index.php"><img src="assets/img/logo.png" alt=""></a> -->
                        </div>
                            <?php echo $msg; ?>                
        
              <div class="form-group">
              	
                            <label>Password</label>
            <input type="password" autofocus="" id="showpassword"  name="password" class="form-control">
            <br>
            <input type="checkbox" style="float: left;" onclick="Show()">
            <p style="float: left; margin-left: 5px; margin-top: -4px;">Show</p><br>
              </div>
     
                        <div class="form-group text-center">
                            <button type="submit" name="reset" class="btn btn-dark account-btn">Reset Password</button>
                        </div>
                      
                    </form>
                </div>
			</div>
        </div>
    </div>
</body>

<script type="text/javascript">
	
	function Show(){

		var	password = document.getElementById("showpassword");
		if(password.type === "password")
		{
			password.type = "text";
		}else{
			password.type = "password";
		}
	}
</script>