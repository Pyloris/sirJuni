<?php
namespace sirJuni\Framework\Helper;

function report($e) {
    echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
}

function redirect($url) {
    header("Location: $url");
}

?>