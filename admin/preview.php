<?php require_once("../resources/Config.php"); 
$user_id = $_SESSION['ID'];
$result = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '{$user_id}'");
$row = mysqli_fetch_array($result);
$background_image = $row['background_image'];
$background_width = $row['background_width'];
$background_height = $row['background_height'];
$XWidth = $row['XWidth'];
$YHeight = $row['YHeight'];
$organization = $row['organization'];
$AvatarOutputX = $row['AvatarOutputX'];
$AvatarOutputY = $row['AvatarOutputY'];
$Zoom = $row['zoom'];


if (isset($_POST['AvatarOutput'])){
        $AvatarX = $_POST['AvatarX'];
        $AvatarY = $_POST['AvatarY'];
//    360
//    340    
        // Update database
        mysqli_query($connection, "UPDATE user SET 	AvatarOutputX = '{$AvatarX}' WHERE organization = '{$organization}'");
        mysqli_query($connection, "UPDATE user SET  AvatarOutputY = '{$AvatarY}' WHERE organization = '{$organization}'");

        // Redirect to apply changes immediately
        header("Location: preview");
        exit();
    }
     
    if (isset($_POST['SetZoom'])){
        $Zoom = $_POST['Zoom'];
        // Update database
        mysqli_query($connection, "UPDATE user SET zoom = '{$Zoom}' WHERE organization = '{$organization}'");

        // Redirect to apply changes immediately
        header("Location: ZoomController.php");
        exit();
    }
    

$imageT = '../upload/output_'.$user_id.'.png';

if(isset($imageT)){
$new_image = '../uploads/ce_avater'. uniqid() .'.png';
$filename = $imageT;   
$newwidth  = 320;
$newheight = 322;
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
  
$page = 'image'; include(TEMPLATE_FRONT . DS . "admin_header.php") 
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
 
body {

	/*background-color: #fafafa;*/
/*	background-color: #eeeeee;*/
    background-color: <?php echo $_SESSION['theme']; ?>;

}
.page-title {
	color: <?php if($_SESSION['theme'] == "black"){echo "#eeeeee";}else{ echo "#555"; } ?>;
	font-size: 21px;
	font-weight: 100;
	margin-bottom: 20px;
}
.img-preview{
    position: absolute; 
    top: -5%; 
    right:37%;          
    }
.form{
    position: relative;
    right: 10px;
    bottom:60px;
    }
form div{
   margin-top:-15px;
    font-weight: 400;
   color: <?php if($_SESSION['theme'] == "black"){echo "#eee";}else{ echo "#555"; } ?>;
    }    
label{
 color: <?php if($_SESSION['theme'] == "black"){echo "#eeeeee";}else{ echo "#555"; } ?>;        
    }    
  button {
    width: auto;
    padding: 0.25rem;
    border-radius: 0.75rem;
    background-color: #0a3d62;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s;
}

button:hover {
    background-color: #0056b3;
}

.btn{
    position: relative;
    left: 370px;
    bottom:60px; 
    border-radius: 0.75rem;
    background-color: #0a3d62;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s;        
    }    
 
   #belowImage {
      position: relative;
      width: 350px;
      height: 360px;
      background-color: lightgray;
      border: 2px dashed gray;
      display: inline-block;
    }
                
               
    #aboveImage {
      position: absolute;
      top: <?php echo $XWidth; ?>px;
      left: <?php echo $YHeight; ?>px;
      width: <?php echo $background_width; ?>px;
      height: <?php echo $background_height; ?>px;
      overflow: hidden;    
      border-radius: 50%;  
/*        Makes the image round */
      object-fit: cover; /* Ensures the image maintains its aspect ratio */
      cursor: grab;
    }

    button {
      margin: 10px;
      padding: 10px 20px;
      font-size: 16px;
    }
    
   .img {
      max-width: 100%;
      height: auto;
      cursor: pointer;
      position: absolute;   
      left: 400px;   
    }

   

@media screen and (max-width: 780px) {


  .img-preview{
margin-left: -70%;
margin-bottom: -90%;
  }

}

  @media screen and (max-width: 572px) {


  .img-preview{

margin-bottom: -150%;
  }

}

  @media screen and (max-width: 480px) {


  .img-preview{

margin-bottom: -190%;
  }

}



</style>
<body>


        <div class="page-wrapper">
            <div class="content">
                
<div class="container">    
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                   <div class="col-md-8" >
                        <img id="belowImage" src="<?php echo $new_image; ?>" alt="No Image">
                    </div>
                
                   </div>           
            
             </div>
     
      </div>
    
     <div>
                    <a href="../download.php" class="btn btn-primary">save</a>
                    <a href="adjust.php" class="btn btn-primary">Back</a>
                    <?php echo '' ?>
    </div>
</div>
  
 <form method="post" class="form">  
<input type="number" name="Zoom" placeholder="Zoom In" value="<?= htmlspecialchars($Zoom); ?>" required>
<button type="submit" name="SetZoom">Enter</button>
</form> 
                
<form method="post" class="form">
<label>Up Emoji</label>:<input type="number" id="cropWidth" name="AvatarX" placeholder="Enter X" value="<?= htmlspecialchars($AvatarOutputX); ?>" required>
<label>Down Emoji</label>:<input type="number" id="cropHeight" name="AvatarY" placeholder="Enter Y" value="<?= htmlspecialchars($AvatarOutputY); ?>" required>
<button type="submit" name="AvatarOutput">Set Avatar Outcome</button>
</form>

            </div>
    </div>        
