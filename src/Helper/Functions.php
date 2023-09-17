<?php
namespace sirJuni\Framework\Helper;

class Helper {
    function public static report($e) {
        echo("File : " . $e->getFile() . "<br\> Line : " . $e->getLine() . "<br\> Message : " . $e->getMessage());
    }

    function public static redirect($url) {
        header("Location: $url");
    }
}

?>