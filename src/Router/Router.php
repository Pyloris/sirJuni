<?php
namespace sirJuni\Framework\Router;

class Router {
    public static function get($path, $callback) {
        if ($_SERVER['REQUEST_URI'] == $path) {
            $callback();
        }
    }
}

?>