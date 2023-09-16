<?php
namespace sirJuni\Framework\Helper;

public static function report($e) {
    echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
}

public static function redirect($url) {
    header("Location: $url");
}

?>