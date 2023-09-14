<?php
namespace sirJuni\Framework\View;


class VIEW {
    public static $path;
    public static function set_path($path) {
        self::$path = $path;
    }

    public static function init($page, $data=NULL) {
        if ($data != NULL)
            extract($data);
        include self::$path . "\\..\\templates\\$page";
    }
}

?>