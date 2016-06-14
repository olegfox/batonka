<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads/media'; // Relative to the root

if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    // Validate the file type
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $newFileName = uniqid() . '.' . $fileParts['extension'];
    $targetFile = rtrim($targetPath, '/') . '/' . $newFileName;

    if (in_array($fileParts['extension'], $fileTypes)) {
        move_uploaded_file($tempFile, $targetFile);
        echo $newFileName;
    } else {
        echo 'Invalid file type.';
    }
}
?>