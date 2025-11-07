

      <?php     

require_once 'config/config.php';
require_once 'config/pdo_db.php';
require_once 'Models/User.php';

      

// instantiate user
$user = new User();

if(isset($_POST['admin'])){
    if($_POST['admin'] == "Yes"){
        $FullName = base64_encode($_POST['FullName']);
        $password = base64_encode($_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);  
        $organization = base64_encode($_POST['organization']);
        $email = base64_encode($_POST['email']);

        header("Location: pay?name={$FullName}&Org={$organization}&psd={$password}&email={$email}");
        exit;
    }
}            
           

if (isset($_POST['final'])) {
    
$_SESSION['msg'] = ""; 
 // VALIDATE POST METHODS
$FullName = trim($_POST['FullName']);
$password = $_POST['password'];
$organization = $_POST['organization'];
$email = $_POST['email'];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$password = password_hash($password, PASSWORD_BCRYPT);  

$result = mysqli_query($connection, "SELECT * FROM user WHERE organization = '{$organization}'");
    
if (mysqli_num_rows($result) == 0){
 $_SESSION['msg'] = "<p class='alert alert-danger alert-dismissible' style='width: 200%; font-size:14px;'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a><small> ADMIN USER NEED TO BE CREATED FIRST</small></p>";       
}else{
    
$row = mysqli_fetch_array($result);                    

$background_width = $row['background_width'];
$background_height = $row['background_height'];
$background_image = $row['background_image'];
$XWidth = $row['XWidth'];
$YHeight = $row['YHeight'];
$Zoom = $row['zoom'];
$AvatarOutputX = $row['AvatarOutputX'];
$AvatarOutputY = $row['AvatarOutputY'];    
$theme = $row['theme']; 

if ($user->countUsers($email) == 0){
     
     $Usersdata = [
        'email' => $email,
        'FullName' => $FullName,
        'organization' => $organization,
        'password' => $password,
        'background_width' => $background_width,
        'background_height' => $background_height,
        'background_image' => $background_image,
        'XWidth' => $XWidth,
        'YHeight' => $YHeight,
        'AvatarOutputX' => $AvatarOutputX,
        'AvatarOutputY' => $AvatarOutputY,
        'zoom' => $Zoom,
        'theme' => $theme
     ];
  // Add User To DB

    $user->addUser($Usersdata);
    header("Location: success"); 
  }else{
    $_SESSION['msg'] = "<p class='alert alert-danger alert-dismissible' style='width: 200%; font-size:14px;'> <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a><small> Email Already Exist</small></p>"; 
  }
    
    
}
    

}





      ?>



<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">    
    <title>Setup Avatar</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styled.css">


<script>
function disableSubmit() {
document.getElementById("submit").disabled = true;
}
function activateButton(element) {

      if(element.checked) {
        document.getElementById("submit").disabled = false;
       }
       else  {
        document.getElementById("submit").disabled = true;
      }
}

</script>

</head>
    
    <style>
    
        form{
            position: relative;
            top: 100px;
            right: 120px;            

        }
        
        input[type=text],
        input[type=password],
        input[type=email]{
            
            width: 250%;
            
        }
        
        .btn{
            width: 40%;
            padding: 0.55rem;
            border-radius: 0.75rem;
            background-color: #0a3d62;
        }
    
    </style>
    
    
<body>

    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="content">

  
<form action="" method="post">
   <?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];} ?>
  <div class="form-group" style="margin-right:30%;">
    <label for="exampleInputEmail1" style="color: #555">Full Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="FullName" placeholder="Enter Full Name" required>
  </div>
  
   <div class="form-group" style="margin-right:30%;">
    <label for="exampleInputEmail1" style="color: #555">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email..." required>
  </div>  
    
   <div class="form-group" style="margin-right:30%;">
    <label for="exampleInputEmail1" style="color: #555; ">Organization / Church</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="organization" placeholder="Enter Organization..." required>
  </div>    
   
  <div class="form-group" style="margin-right:30%;">
    <label for="exampleInputEmail1" style="color: #555">Password</label>
    <input type="password" class="form-control" id="exampleInputEmail1" name="password" placeholder="Enter Password" required>
      <small id="emailHelp" style="color: orange;" class="form-text "><span>Are You A Admin: </span></small>
      <small>Yes: <input type="radio" name="admin" value="Yes">   No: <input type="radio" name="admin" value="No"></small> 
    
     
        
  </div>
    


  <body onload="disableSubmit()">
 <input type="checkbox" name="terms" id="terms" onchange="activateButton(this)">  <small style="font-size: 13px; color: #555;">I Agree to Terms & Conditions</small>
<br><br>
  <button type="submit" name="final" class="btn btn-primary" id="submit">Setup</button>

</body>


</form>

            </div>


 
    <div class="sidebar-overlay" data-reff=""></div>

<!-- JavaScript/jQuery code for AJAX request -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <script type="text/javascript">
$(document).ready(function(){

jQuery('#export-to-excel').bind('click', function(){

var target = $(this).attr('id');
// alert(target);
switch(target){
    case  'export-to-excel' :
    $('#hidden-type').val(target);
    $('#export-form').submit();
    break;
}

});
    });

</script>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- <script src="assets/js/jquery.dataTables.min.js"></script> -->
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>


 