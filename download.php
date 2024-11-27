<?php
if (isset($_GET['file'])) {
    $filepath = $_GET['file'];



    $allowedPath = 'C:\xampp\htdocs\Employee\uploads file'; 
    $realpath = realpath($allowedPath . $filepath);

    if ($realpath !== false && strpos($realpath, $allowedPath) === 0) {
       
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($realpath) . '"');
        readfile($realpath);
        exit;
    }
}
