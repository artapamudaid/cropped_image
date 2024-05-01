<?php


$source = './image_temp/' . $_POST['foto']; // Change this to the path of your source file
$destination = './foto/' . $_POST['foto']; // Change this to the path where you want to move the file


echo $source;

// Check if the source file exists
if (file_exists($source)) {
    // Attempt to move the file
    if (rename($source, $destination)) {
        echo "File moved successfully.";
    } else {
        echo "Error moving file.";
    }
} else {
    echo "Source file does not exist.";
}
