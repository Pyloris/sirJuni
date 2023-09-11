<?php
namespace sirJuni\Framework\Helper;

class HelperFuncs {

    public static function trim_slash($path) {
        return preg_replace('/^\/||\/$/', '', $path);
    }

    public static function report($e) {
        echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
    }
}

?>