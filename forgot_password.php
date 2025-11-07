<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
    <title>Forgot Password</title>
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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


    $result = "";
    $username = "";
if (isset($_POST["forgot"])) {
	$email = $_POST["email"];

	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);

	if (!$email || empty($email)) {		
	$result = "<p class='alert alert-danger alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Invalid email address enter a valid email address!</p>";
	}else{

    $query = $user->storedPassword($email);
    foreach ($query as $row) {
    $username = $row->FullName; 
    }
    $count = $user->countUsers($email);
    
	if ($count == 0){
	 $result = "<p class='alert alert-danger alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a> No Valid Users</p>";
    
	}

	}


$subject = ""; 
$token = bin2hex(random_bytes(50));
$sql = $user->forgot_password($email,$token);

$servername = $_SERVER['SERVER_NAME'];
$link = "http://$servername/refactored_avatar/reset-password?token=$token";  

$subject .= '<p>Please click on the following link to reset your password.</p>';
$subject .= "<p><a href='$link'>$link</a></p>";
$subject .= wordwrap($subject,70);







//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tonytechonology@gmail.com';            //SMTP username
    $mail->Password   = 'frdghoziwmnwolvx';                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('tonytechonology@gmail.com', 'Thinkpatch');
    $mail->addAddress($email, $username);     //Add a recipient
    $mail->addReplyTo("tonytechonology@gmail.com", "Thinkpatch");

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Recovery';
    $mail->Body    = $subject;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $result = "<p class='alert alert-success alert-dismissible'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Mail has been sent</p>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
                          <?php echo $result ?> 
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" autofocus="" name="email" class="form-control" required>
                        </div>
     
                        <div class="form-group text-center">
                            <button type="submit" name="forgot" class="btn btn-dark account-btn">Forgot Password</button>
                        </div>
                      
                    </form>
                </div>
			</div>
        </div>
    </div>
</body>