<?php 
require_once('../config/config.php');
if(isset($_POST['uploadfile'])){
$user_id = $_SESSION['ID'];
$organization = $_SESSION['organization'];
$folder = '../upload/'; 
$image = $_FILES['img']['name'];
$tempname = $_FILES['img']['tmp_name'];
move_uploaded_file($tempname, $folder."".$image);    

$outputFile =  '../upload/'.'Output'.$user_id .'.png';
$originalFile =  '../upload/'.$image;
$output =  'Output'.$user_id .'.png';
$width = "350";
$height = "350";
    
 function resizeImage($originalFile, $outputFile, $newWidth, $newHeight = null){
     
//     if(!file_exists($originalFile)){
//         die("Error: File not found. ");
//     }
     
     $info = getimagesize($originalFile);
     if(!$info){
         die("Error: Unable to determine image type.");
     }
     
     $mime = $info['mime'];
     switch($mime){
         case 'image/jpeg':
             $image_create_func = 'imagecreatefromjpeg';
             $image_save_func = 'imagejpeg';
             break;
         case 'image/png':
             $image_create_func = 'imagecreatefrompng';
             $image_save_func =   'imagepng';
             break;
         case 'image/gif':
             $image_create_func = 'imagecreatefromgif';
             $image_save_func = 'imagegif';
             break;
         default:
             die("Error: Unsupported file format.");
     }
     
     $originalImage = $image_create_func($originalFile);
     
     $width = imagesx($originalImage);
     $height = imagesy($originalImage);
     
     if($newHeight == null){
         $newHeight = ($newWidth / $width) * $height;
     }
     
     $resizedImage = imagecreatetruecolor($newWidth,$newHeight);
     imagecopyresampled($resizedImage,$originalImage,0,0,0,0,$newWidth,$newHeight,$width,$height);
     
     if($image_save_func($resizedImage,$outputFile)){
//         echo "Image successfully resized and saved as: $outputFile";
     }else{
//         echo "Error: Failed to save the resized image.";
         exit;
     }
     
     imagedestroy($originalImage);
     imagedestroy($resizedImage);
 }    
    
    resizeImage($originalFile,$outputFile,$width,$height);
  

$stmt = mysqli_query($connection, "UPDATE user SET background_image = '{$output}' WHERE organization = '{$organization}'");
$result = mysqli_query($connection,  "SELECT background_image FROM user WHERE user_id = '{$user_id}'");

$row = mysqli_fetch_array($result);
$background_image = $row['background_image'];
}

?>

<div class="container">    
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                   
                  <div class="sample_image" style="object-fit: cover; width: 300px; height: 300px;">
                      
                      <!-- <img src="upload/avatar.png" id="sample_image" style="object-fit: cover; width: 300px; height: 300px;"> -->
                  </div>
                   <div class="col-md-8 img-preview" style="object-fit: cover; position: absolute; bottom: 45%; left: 2%;">
                     <img src="../upload/<?php echo $background_image; ?>" alt="">
                                   
<!--                    <div class="preview" style="position: absolute; top: 153px; left: 142.5px; width: 116px; height: 116px; border-radius: 540px;"><img style="display: block; width: 189.942px; height: 189.942px; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; transform: translateX(-36.9209px) translateY(-39.298px);" src="upload/avatar.png"></div>-->
 
                    </div>
                   </div>
             </div>
      </div>

                <form  action="" method="post" enctype="multipart/form-data" style="object-fit: cover; position: absolute; bottom: 35%; left: 2%;">
                  <input type="file" name="img" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff"  />
                  <button type="submit" name="uploadfile" >Save</button>

                </form>
  
                        
</div>