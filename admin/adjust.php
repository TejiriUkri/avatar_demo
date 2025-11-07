<?php
require_once("../resources/Config.php");

// Secure session check
$user_id = (int)$_SESSION['ID'];

// Use prepared statements for security
$stmt = $connection->prepare("SELECT XWidth, YHeight, background_width, background_height, background_image, organization, subscription_expiry FROM user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: logout.php");
    exit;
}

// Sanitize user data
$XWidth = (int)$user['XWidth'];
$YHeight = (int)$user['YHeight'];
$background_width = (int)$user['background_width'];
$background_height = (int)$user['background_height'];
$background_image = htmlspecialchars($user['background_image']);
$organization = htmlspecialchars($user['organization']);
$expiryDate = $user['subscription_expiry']; 

// Handle file upload
$uploaded_image = '../upload/avatar.png'; // Default image

//
if(strtotime($expiryDate) < time()){
   $expiryDate= base64_encode($expiryDate);
 header("Location: status_sub.php?pid={$expiryDate}");
exit();
}



// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    if (isset($_POST['uploadfile'])) {
        $cropWidth = $_POST['cropWidth'];
        $cropHeight = $_POST['cropHeight'];
        // Update database
        mysqli_query($connection, "UPDATE user SET background_width = '{$cropWidth}' WHERE organization = '{$organization}'");
        mysqli_query($connection, "UPDATE user SET background_height = '{$cropHeight}' WHERE organization = '{$organization}'");

        // Redirect to apply changes immediately
        header("Location: Tester");
        exit();
           
    }
    
    if (isset($_POST['SetX'])){
        $XWidth = $_POST['XWidth'];
        $YHeight = $_POST['YHeight'];
        // Update database
        mysqli_query($connection, "UPDATE user SET XWidth = '{$XWidth}' WHERE organization = '{$organization}'");
        mysqli_query($connection, "UPDATE user SET YHeight = '{$YHeight}' WHERE organization = '{$organization}'");

        // Redirect to apply changes immediately
        header("Location: Tester");
        exit();
    }
    
    
}
?>
<?php $page = 'image'; include(TEMPLATE_FRONT . DS . "admin_header.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage your user avatar with our intuitive editor">
    <title>User Avatar Editor</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/cropper.min.css">
    <link rel="stylesheet" href="../assets/css/avatar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
      <script src='../assets/asst/jquery-3.0.0.js' type='text/javascript'></script>
    <link href="../assets/asst/cropper.css" rel="stylesheet"/>
     <script src="../assets/asst/cropper.js"></script>
</head>
    <style type="text/css">
 /* Reset and base styles */

body {

    background-color: <?php echo $_SESSION['theme']; ?>;

}        

.page-title {
	color: <?php if($_SESSION['theme'] == "black"){echo "#eeeeee";}else{ echo "#555"; } ?>;
	font-size: 21px;
	font-weight: 100;
	margin: 35px 60px;
}
        
/* Main content */
main {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.avatar-editor {
    position: relative;
    bottom: 100px;
    background-color: <?php echo $_SESSION['theme']; ?>;
    border-radius: var(--border-radius);
    overflow: hidden;
}

.card-body {
    padding: 6rem;
}

/* Image container */
.image-container {
    position: relative;
    left: 50px;
    width: 350px;
    height: 360px;
    overflow: hidden;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}



/* Avatar preview */
.avatar-preview {
    position: relative;  
    background-color: #e9ecef;
    border: 2px dashed var(--text-muted);
    border-radius: var(--border-radius);
    overflow: hidden;
}

#below-image {

    object-fit: cover;
}

#aboveImage {
    position: absolute;
    top: calc(<?php echo $XWidth; ?>px * 0.97);
    left: calc(<?php echo $YHeight; ?>px * 0.88);
    width: <?php echo $background_width; ?>px;
    height: <?php echo $background_height; ?>px;
    overflow: hidden;
    border-radius: 50%;
    box-shadow: var(--shadow);
    object-fit: cover;
    cursor: grab;
}

.form{
    position: relative;
    bottom:270px;
    margin-left:240px;
    }
.form div{
   margin-top:-5px;
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
    left: 780px;
    top:10px; 
    border-radius: 0.75rem;
    background-color: #0a3d62;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s;        
    }    
         

/* Responsive design */
@media (max-width: 992px) {
 form{
   position: relative;
   left:0px;
   top:0px;
}
        
.form-control {
    width: auto;

}
    .avatar-preview {
        width: 350px;
        height: 360px;
        margin: 0 auto;
    }
    #aboveImage {
        width: calc(<?php echo $background_width; ?>px * 0.75);
        height: calc(<?php echo $background_height; ?>px * 0.75);
    }

    .page-title {
        font-size: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }
    .btn-outline-light {
    margin-left: 50px;
  
}
}

@media (max-width: 576px) {
    
form{
   position: relative;
   left:0px;
   top:0px;
}
        
.form-control {
    width: auto;

}
.btn-outline-light {
    margin-left: 50px;
  
}
    .avatar-preview {
        width: 350px;
        height: 360px;
        margin: 0 auto;
    }

    #aboveImage {
        width: calc(<?php echo $background_width; ?>px * 1);
        height: calc(<?php echo $background_height; ?>px * 1);
    }

    .image-container {
        margin-bottom: 1.5rem;
    }

    .btn-primary,
    .btn-success {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .d-flex.gap-3 {
        flex-direction: column;
        gap: 1rem;
    }
}
/* Animations */
.btn {
    transition: all 0.3s ease;
}
    
    .image-container img,
.avatar-preview img {
    transition: transform 0.3s ease;
}

.image-container img:hover,
.avatar-preview img:hover {
    transform: scale(1.02);
}
}
</style>
<body>

 

    <main class="container my-5">
        
        
        <section class="avatar-editor card shadow-sm">
            <div class="card-body">
               <div class="row">
                  <div class="col-sm-8 col-6">
                <h4 class="page-title">ADJUST AVATAR</h4>
                  </div>         
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="image-container">
                            <img src="<?php echo htmlspecialchars($uploaded_image); ?>" id="sample_image" alt="Avatar preview" class="img-fluid" loading="lazy">
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="avatar-preview">
                            <img id="below-image" src="../upload/<?php echo $background_image; ?>" alt="Background image" loading="lazy">
                            <div id="aboveImage">
                                <img src="<?php echo htmlspecialchars($uploaded_image); ?>" alt="Cropped avatar preview" draggable="false">
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
        </section>
    </main>
    
        <form method="post" class="form">
        <label>W: </label>
        <input type="number" id="cropWidth" name="cropWidth" placeholder="Enter Width" value="<?= htmlspecialchars($background_width); ?>" required>
        <label>H: </label>
        <input type="number" id="cropHeight" name="cropHeight" placeholder="Enter Height" value="<?= htmlspecialchars($background_height); ?>" required>
        <button type="submit" name="uploadfile">Set Image Size</button>
    </form>
                
    <form method="post" class="form">
        <label>X: </label>
        <input type="number" id="cropWidth" name="XWidth" placeholder="Enter X Co-ordinate" value="<?= htmlspecialchars($XWidth); ?>" required>
        <label>Y: </label>
        <input type="number" id="cropHeight" name="YHeight" placeholder="Enter Y Co-ordinate" value="<?= htmlspecialchars($YHeight); ?>" required>
        <button type="submit" name="SetX">Set Coordinate</button>
     <div>Preview Output Image: <a href="preview"> Preview Downloadable Copy</a></div>     
    </form>
   
    <script src="../script.js"></script>
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
	<script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script> 
   <script src="../assets/js/app.js"></script>

    
<script>

$(document).ready(function(){

var image = document.getElementById('sample_image');

var cropper;

$("#upload_image").change(function(event){

$('#target').submit();

});

 cropper = new Cropper(image, {
           aspectRatio: 1,
           viewMode: 0,
           preview:'#aboveImage'
      });




    $('#crop').click(function(){
        canvas = cropper.getCroppedCanvas({
           
        });

        canvas.toBlob(function(blob){
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function(){
                var base64data = reader.result;
                $.ajax({
                    url:'upload.php',
                    method:'POST',
                    data:{image:base64data},
                    success:function(data)
                    {
                        
                      $('#uploaded_image').attr('src', data);
                        window.location.href = "download.php";

//                      $('.download').html('<button type="button" class="btn btn-primary">Download</button>');
//                        
                    }
                });
            };
        });
    });
    
});
</script>
</body>
</html>