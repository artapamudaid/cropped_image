<?php
// Check if the request method is POST and if a file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["croppedImage"])) {
    $target_dir = "image_temp/";

    // Generate a unique name for the file
    $timestamp = time();
    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
    $newFileName = $timestamp . "_" . $randomString . ".png";

    $target_file = $target_dir . $newFileName;

    // Move the uploaded file to the specified directory with the new file name
    if (move_uploaded_file($_FILES["croppedImage"]["tmp_name"], $target_file)) {
        echo $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    echo "Invalid request";
}
