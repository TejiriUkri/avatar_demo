<?php
require_once 'config/config.php';

// Secure session check
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 0 || !isset($_SESSION['ID'])) {
    header("Location: logout.php");
    exit;
}

$user_id = (int)$_SESSION['ID'];

// Use prepared statements for security
$stmt = $connection->prepare("SELECT XWidth, YHeight, background_width, background_height, background_image FROM user WHERE user_id = ?");
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

// Handle file upload
$uploaded_image = 'upload/avatar.png'; // Default image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff'];
    $file_type = mime_content_type($_FILES['image']['tmp_name']);
    
    if (in_array($file_type, $allowed_types) && $_FILES['image']['size'] <= 5 * 1024 * 1024) { // 5MB limit
        $filename = uniqid() . '-' . basename($_FILES['image']['name']);
        $folder = 'upload/' . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
            $_SESSION['folder'] = $folder;
            $uploaded_image = $folder;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage your user avatar with our intuitive editor">
    <title>User Avatar Editor</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/cropper.min.css">
    <link rel="stylesheet" href="assets/css/avatar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
      <script src='assets/asst/jquery-3.0.0.js' type='text/javascript'></script>
    <link href="assets/asst/cropper.css" rel="stylesheet"/>
     <script src="assets/asst/cropper.js"></script>
</head>
    <style type="text/css">
 /* Reset and base styles */
:root {
    --primary-color: #0a3d62;
    --secondary-color: #6c757d;
    --success-color: #0a3d62;
    --background-color: #f8f9fa;
    --card-background: #eeeeee;
    --text-color: #333333;
    --text-muted: #6c757d;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --border-radius: 8px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

    
body {
    font-family: 'Rubik', sans-serif;
    font-size: 0.875rem;
    color: #666;
    line-height: 1.5;
    background-color: var(--background-color);
    overflow-x: hidden;
    min-height: 100vh;
}
   /* Header */
.site-header {
    background-color: var(--primary-color);
    color: #ffffff;
    padding: 1rem 0;
    box-shadow: var(--shadow);
}

.page-title {
    font-size: 1.75rem;
    font-weight: 200;
    margin: 0;
}
        

.btn-outline-light {
    margin-left: 300px;
    border-color: #ffffff;
    color: #ffffff;
    transition: background-color 0.3s, color 0.3s;
}

.btn-outline-light:hover {
    background-color: #ffffff;
    color: var(--primary-color);
}


/* Main content */
main {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.avatar-editor {
    background-color: var(--card-background);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.card-body {
    padding: 6rem;
}

/* Image container */
.image-container {
    position: relative;
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



/* Form styles */
form{
   position: relative;
    left:530px;
    top:0px;
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
    font-size: 0.875rem;
    color: var(--text-muted);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    border-radius: var(--border-radius);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
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
    font-weight: 500;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-success:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    transform: translateY(-2px);
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
    <header class="site-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h1 class="page-title">Avatar Editor</h1>
                </div>
                <div class="col-6 text-end" id="logout">
                    <a href="logout.php" class="btn btn-outline-light">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container my-5">
        <section class="avatar-editor card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="image-container">
                            <img src="<?php echo htmlspecialchars($uploaded_image); ?>" id="sample_image" alt="Avatar preview" class="img-fluid" loading="lazy">
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="avatar-preview">
                            <img id="below-image" src="upload/<?php echo $background_image; ?>" alt="Background image" loading="lazy">
                            <div id="aboveImage">
                                <img src="<?php echo htmlspecialchars($uploaded_image); ?>" alt="Cropped avatar preview" draggable="false">
                            </div>
                        </div>
                    </div>
                </div>
                <form action="" method="post" id="target" enctype="multipart/form-data" class="mt-4">
                    <div class="mb-3">
                        <label for="upload-image" class="form-label visually-hidden">Upload Image</label>
                        <input type="file" name="image" id="upload_image" accept="image/jpeg,image/png,image/gif,image/bmp,image/tiff" class="form-control" aria-describedby="upload-help">
                        <div id="upload-help" class="form-text">Supported formats: JPG, PNG, GIF, BMP, TIFF. Max size: 5MB.</div>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="button" id="crop" class="btn btn-success">Crop & Save</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

 <script src="script.js"></script>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
    
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