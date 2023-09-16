<?php
namespace sirJuni\Framework\Helper;


public static function trim_slash($path, $pos=NULL) {
    if ($pos == 'start')
        return preg_replace('/^\//', '', $path);
    else if ($pos == 'end')
        return preg_replace('/\/$/', '', $path);
    else 
        return preg_replace('/^\/||\/$/', '', $path);
}

public static function report($e) {
    echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
}

public static function redirect($url) {
    header("Location: $url");
}

function hello() {
    echo("HELLO");
}

?>