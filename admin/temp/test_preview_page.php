<?php require_once("../resources/Config.php"); 

$user_id = $_SESSION['ID'];
$result = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '{$user_id}'");
$row = mysqli_fetch_array($result);
$background_image = $row['background_image'];
$background_width = $row['background_width'];
$background_height = $row['background_height'];
$XWidth = $row['XWidth'];
$YHeight = $row['YHeight'];

$imageT = '../upload/output_'.$user_id.'.png';

if(isset($imageT)){
$new_image = '../uploads/ce_avater'. uniqid() .'.png';
$filename = $imageT;   
$newwidth  = 220;
$newheight = 222;
$zoom = $row['zoom'];
      
 

$masked_image = $imageT;
$image_backgound = "../upload/".$background_image;
$image_masked = imagecreatefromstring(file_get_contents($masked_image));
$backgound = imagecreatefromstring(file_get_contents($image_backgound));

$width = imagesx($backgound);
$height =  imagesy($backgound);

$maskWidth = imagesx($image_masked);
$maskHieght =  imagesy($image_masked);

$dst_W = 660;
$dst_h = 660;

$image = imagecreatetruecolor($dst_W, $dst_h);

imagecopyresampled($image, $backgound, 0, 0, 0, 0, $dst_W, $dst_h, $width, $height);

imagecopymerge($image, $image_masked, $row['AvatarOutputX'], $row['AvatarOutputY'], 0, 0, $dst_W, $dst_h, 100);
//imagecopymerge($image, $image_masked, 240, 287, 0, 0, $dst_W, $dst_h, 100);

imagepng($image, $new_image);
imagedestroy($image);
	



}

?>


<!DOCTYPE htmls>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
    <title></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script src='assets/ass/jquery-3.0.0.js' type='text/javascript'></script>
        <link rel="stylesheet" href="Mystyle.css">
    <link href="assets/ass/cropper.css" rel="stylesheet"/>
    
    <script src="assets/ass/cropper.js"></script>

</head>
<style>
  #belowImage {
      position: relative;
      width: 400px;
      height: 400px;
      background-color: lightgray;
      border: 2px dashed gray;
      display: inline-block;
    }
        

</style>
<body>


        <div class="page-wrapper">
            <div class="content">
                
<div class="container">    
      <div class="modal-body">
        <div class="img-container">
            <div class="row">

<?php  echo "<div style='text-align:center;'><img  src= " . $new_image ." ></div>"; ?>                
               

            </div>
        </div>        
