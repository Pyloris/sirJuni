<?php
namespace sirJuni\Framework\Helper;

// This is a simple library with functions 

// Remove '/' from path
function trim_slash($path) {
    return preg_replace('/\//', '', $path);
}

?>