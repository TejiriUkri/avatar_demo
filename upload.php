<?php
ob_start();
session_start();
$connection = mysqli_connect('localhost','root','','avatar');
$user_id = $_SESSION['ID'];
$result = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '{$user_id}'");
$row = mysqli_fetch_array($result);

$background_image = $row['background_image'];
$background_width = $row['background_width'];
$background_height = $row['background_height'];
$XWidth = $row['XWidth'];
$YHeight = $row['YHeight'];



if(isset($_POST['image'])){
$new_image = 'uploads/ce_avater'. uniqid() .'.png';
$_SESSION['image_avater'] = $new_image;
$filename = $_POST['image'];   
$newwidth  = 320;
$newheight = 322;
$zoom = $row['zoom'];
      
mysqli_query($connection, "UPDATE user SET avatar = '{$new_image}' WHERE user_id = '{$user_id}'");

avatar($filename,$newwidth,$newheight,$zoom,$user_id);

$masked_image = "upload/output_".$user_id.".png";
$image_backgound = "upload/".$background_image;
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





function avatar($filename,$newwidth,$newheight,$zoom,$user_id){

$new_image = "upload/output_".$user_id.".png";

$image_s = imagecreatefromstring(file_get_contents($filename));
$width = imagesx($image_s);
$height = imagesy($image_s);

$image = imagecreatetruecolor($newwidth, $newheight);
imagealphablending($image, true);
imagecopyresampled($image, $image_s, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// create masking

$mask = imagecreatetruecolor($newwidth, $newheight);

$transparent = imagecolorallocate($mask, 255, 0, 0);
imagecolortransparent($mask, $transparent);

imagefilledellipse($mask, $newwidth/2, $newheight/2, $zoom, $zoom, $transparent);

$red = imagecolorallocate($mask, 0, 0, 0);
imagecopymerge($image, $mask, $background_width, $background_height, 0, 0, $newwidth, $newheight, 100);
imagecolortransparent($image,$red);
imagefill($image, 0, 0, $red);

// header('Content-Type: image/png');
// imagepng($image_s);
imagepng($image, $new_image);
imagedestroy($image);
imagedestroy($mask);


// echo "<div style='text-align:center;'><img  src= " . $new_image ." ></div>";


}