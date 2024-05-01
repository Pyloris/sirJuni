<?php
namespace sirJuni\Framework\Helper;

class HelperFuncs {
    public static function report($e) {
        echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
    }

    public static function redirect($url) {
        header("Location: $url");
    }
}

?>