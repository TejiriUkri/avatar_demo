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


$imageT = '../upload/avatar.png';



if(isset($imageT)){

$filename = $imageT;   
$newwidth  = 320;
$newheight = 322;
$zoom = $row['zoom'];
      

avatar($filename,$newwidth,$newheight,$zoom,$user_id);

  
header("Location: preview.php");
exit();    
}





function avatar($filename,$newwidth,$newheight,$zoom,$user_id){

$new_image = "../upload/output_".$user_id.".png";

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


imagepng($image, $new_image);
imagedestroy($image);
imagedestroy($mask);


}