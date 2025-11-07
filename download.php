<?php
$imagesDir = 'uploads/';
$images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if ($images) {
    // Sort images by their last modified time (descending)
    usort($images, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    $latestImage = $images[0]; // Get the most recent image


    if (file_exists($latestImage)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($latestImage) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($latestImage));

        readfile($latestImage);
        exit;
    } else {
        echo "File not found!";
    }
} else {
    echo "No images found.";
}  
?>


