<?php require_once("../resources/Config.php"); ?>
<?php 
$user_id = $_SESSION['ID'];
$organization = $_SESSION['organization'];
$result = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '{$user_id}'");
$row = mysqli_fetch_array($result); 
$expiryDate = $row['subscription_expiry']; 
    


if(isset($_POST['uploadfile'])){

    if(strtotime($expiryDate) < time()){
          $expiryDate= base64_encode($expiryDate);
          header("Location: status_sub.php?pid={$expiryDate}");
          exit();
    }
    
$folder = '../upload/'; 
$image = $_FILES['img']['name'];
$tempname = $_FILES['img']['tmp_name'];
move_uploaded_file($tempname, $folder."".$image);    

$outputFile =  '../upload/'.$image;
$originalFile =  '../upload/'.$image;
$output =  $image;
$width = "350";
$height = "350";
    
if(empty($image)){
  die("Error: Upload is empty. ");
}    
    
 function resizeImage($originalFile, $outputFile, $newWidth, $newHeight = null){
     
     if(!file_exists($originalFile)){
         die("Error: File not found. ");
     }
     
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
}

$result = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '{$user_id}'");
$row = mysqli_fetch_array($result);                    
$image = $row['background_image'];
$subscription_expiry = $row['subscription_expiry'];

?>

<?php $page = 'image'; include(TEMPLATE_FRONT . DS . "admin_header.php") ?>

<style>
    :root {
    --primary-color: #0057d8;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --background-color: #f8f9fa;
    --card-background: #f4f4f4;
    --text-color: #333333;
    --text-muted: #6c757d;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --border-radius: 8px;
}
      body {
     background-color: <?php echo $_SESSION['theme']; ?>;
        }
    form{
        margin: -60px 240px;
    }
.adjust{
    color: aliceblue;
    position: absolute;
    bottom: 10%;
    margin-left: 150px;
    font-weight: 300;
}
    
 #belowImage {
     
      background-color: lightgray;
      border: 2px dashed gray;
      display: inline-block;
    }
       

.form{
position: relative;
right:93px;
top:90px;
}
    
.form-control {
    width: auto;
    border-radius: var(--border-radius);
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 87, 216, 0.25);
}

.form-text {
    width: auto;
    font-size: 0.870rem;
    color: var(--text-muted);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    border-radius: var(--border-radius);
    padding: 0.30rem 0.85rem;
    margin: auto;
    position: relative;
    left: 30px;
    bottom: 78px;
    font-weight: 350;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-primary:hover {
    background-color: #0047b3;
    border-color: #0047b3;
    transform: translateY(-2px);
}

.btn-success {
    background-color: var(--success-color);
    border-color: var(--success-color);
    border-radius: var(--border-radius);
    padding: 0.75rem 1.5rem;
    font-weight: 300;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #218838;
    transform: translateY(-2px);
}

/* Responsive design */
@media (max-width: 992px) {

    
.form{
        position: relative;
        left: -165px;
        bottom:10px;    
    }
   .form-text {
    width: 500px;
  }
    .adjust{
   
    margin-left: 70px;
   }
    
 .btn-primary {
  
    position: relative;
    left: 290px;
    bottom: 90px;
  }        
}

@media (max-width: 576px) {
    
    
    .form{
        position: relative;
        left: -170px;
        bottom:10px;    
    }
    .form-text {
    width: 500px;
  }
    .adjust{
   
    margin-left: 70px;
   }
    
 .btn-primary {
  
    position: relative;
    left: 290px;
    bottom: 90px;
  }    
}





/* Animations */
.btn {
    transition: all 0.3s ease;
}

    
    

</style>
<div class="container">    
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                   
                  <div class="sample_image" style="object-fit: cover; width: 300px; height: 300px;">
                      
                      <!-- <img src="upload/avatar.png" id="sample_image" style="object-fit: cover; width: 300px; height: 300px;"> -->
                  </div>
                   <div class="col-md-8 img-preview" style="object-fit: cover; position: absolute; bottom: -30%; left: 12%;">
                       <?php if(!empty($image)){ ?>
                     <img id="belowImage" src="../upload/<?php echo $image; ?>" alt="">
                        <?php }else{?>                   
                        <img id="belowImage" src="../upload/avatar.png" alt="">
                       <?php }?>           
<!--                    <div class="preview" style="position: absolute; top: 153px; left: 142.5px; width: 116px; height: 116px; border-radius: 540px;"><img style="display: block; width: 189.942px; height: 189.942px; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; transform: translateX(-36.9209px) translateY(-39.298px);" src="upload/avatar.png"></div>-->
 
                    </div>
                   </div>
             </div>
      </div>

<!--
                <form  action="" method="post" enctype="multipart/form-data" style="object-fit: cover; position: absolute; bottom: 35%; left: 2%;">
                  <input type="file" name="img" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff"  />
                  <button type="submit" name="uploadfile" >Save</button>

                </form>
    
-->
    
                <form action="" method="post" enctype="multipart/form-data" class="mt-4 form">
                    <div class="mb-3">
                        <input type="file" name="img" id="upload-image" accept="image/jpeg,image/png,image/gif,image/bmp,image/tiff" class="form-control" aria-describedby="upload-help">
                        <div id="upload-help" class="form-text">Supported formats: JPG, PNG, GIF, BMP, TIFF. Max size: 5MB.</div>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" name="uploadfile" class="btn btn-primary">Upload Image</button>
                        
                    </div>
                </form>
    
 
    <div class="adjust">  
    <p>To adjust image to fit in your background image <a href='adjust'>Click here</a> </p>
   </div>
                        
</div>

    <script src="../assets/js/jquery-3.2.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script> 
   <script src="../assets/js/app.js"></script>