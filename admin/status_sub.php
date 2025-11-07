<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
    <title>NO ACTIVE SUBSCRIPTION</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styled.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>
 <style>
    .blue-color {
        color:blue;
    }
     
    .green-color {
        color:green;
    }
     
    .teal-color {
        color:teal;
    }
     
    .yellow-color {
    color:yellow;
    }
    
    .red-color {
        color:red;
    }
    .text{
        font-size: 18px;
    }
    small a {
        font-size: 15px;   
    }
   </style>
<body>
    <div class="main-wrapper error-wrapper">
        <div class="error-box">
            <h1><i class="fa fa-warning red-color"></i></h1>
            <p><small class="text">NO ACTIVE SUBSCRIPTION; EXPIRED AS OF<?php 
            $pid = base64_decode($_GET['pid']);
            $date = date('F j, Y', strtotime($pid));    
            echo " " . strtoupper($date); ?> .</small></p>
            <small><a href="pay.php">RETURN TO PAYMENT GATEWAY</a></small>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>