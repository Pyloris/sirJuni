<?php
namespace sirJuni\Framework\Helper;

// This is a simple library with functions 

// Remove '/' from path
function trim_slash($path) {
    return preg_replace('/\//', '', $path);
}


// report the error
function report($e) {
    echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
}


// include every file in a standard dir
function include_every($path) {
    $files = scandir($path);
    for ($files as $file) {
        $filePath = CONTROLLERS . '/' . $file;
        if (is_file($filePath)) {
            require_once $filePath;
        }
    }
}

?>