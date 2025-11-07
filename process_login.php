<?php
require_once('config/config.php');
require_once('config/pdo_db.php');
require_once('Models/User.php');
$user = new User;

if (isset($_SESSION['ID'])) {
    $user->redirect('error-500.php');
}else{


if(isset($_POST['csrf_token'])){
$email = trim($_POST['email']);
// remember to encrpty password
$password = $_POST['password'];
$results = $user->storedPassword($email);
foreach ($results as $result){
$storedPassword = $result->password;
}

//$hash = password_hash($storedPassword, PASSWORD_DEFAULT);
if(password_verify($password, $storedPassword)){
if($rows = $user->Getuser($email,$storedPassword)){
        foreach ($rows as $row){    

   $_SESSION['ID'] = $row->user_id;
   $_SESSION['status'] =  $row->status; 
   $_SESSION['email'] = $row->email;
   $_SESSION['organization'] = $row->organization;
   $_SESSION['pwd'] = $row->password;

if ($row->status == 1){
$user->redirect("./admin/index");

}else{
 $user->redirect("./avatar");    
}

}

}

}
else{
    $_SESSION['invalid'] = "<small class='bg bg-danger' style='color:white; font-size:14px;'>Invaild Email Or Password</small>";
    header("Location: login");
}



}

}

?>