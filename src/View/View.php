<?php
namespace sirJuni\Framework\View;


class VIEW {
    public static $path;
    public static function set_path($path) {
        self::$path = rtrim($path, '\\');
    }

    public static function init($page, $data=NULL) {
        if ($data != NULL)
            extract($data);
        include self::$path . "\\$page";
    }
}

?>