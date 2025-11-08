       
<?php
// Check if user is logged in
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 1) {
    header("Location: ../logout.php");
    exit();
}
?>

<!DOCTYPE htmls>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
    <title>Admin Portal</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
   <link rel="stylesheet" href="Mystyle.css">
    
    <script src='../assets/ass/jquery-3.0.0.js' type='text/javascript'></script>
    <link href="../assets/ass/cropper.css" rel="stylesheet"/>
    <script src="../assets/ass/cropper.js"></script>

</head>

<body>
    <div class="main-wrapper">
       <div class="header">
			<div class="header-left">
				<a href="index" class="logo">
					<?php
           $companylogo = "";
           if (isset($_SESSION['companyName'])) {
           $companylogo = $_SESSION['companyName'];          
             }
           echo '<img src="assets/logo/'.$companylogo.'.png" width="35" height="35" alt="logo">' ?> <span>Admin Portal </span>
				</a>
			</div>


            <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">                 
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
							<img class="rounded-circle" src="../assets/img/user.jpg" width="24" alt="Admin">
							<span class="status online"></span>
						</span>
						<span><?php echo $_SESSION['email'];?></span>
                    </a>
					<div class="dropdown-menu">
            <a class="dropdown-item" href="change-password?user=<?php echo base64_encode($_SESSION['ID']); ?>">Change Password</a>
						<a class="dropdown-item" href="../logout.php">Logout</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="change-password?user=<?php echo base64_encode($_SESSION['ID']); ?>">Change Password</a>
                    <a class="dropdown-item" href="profile?user=<?php echo base64_encode($_SESSION['ID']); ?>">My Profile</a>
                    <a class="dropdown-item" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>

        <?php include(TEMPLATE_FRONT . DS . "admin_sidebar.php") ?>
        
        

