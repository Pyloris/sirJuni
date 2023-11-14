<?php
namespace sirJuni\Framework\Middleware;

use sirJuni\Framework\Helper\HelperFuncs;

// Middleware should implement following methods
class Middleware {
    public static $url;

    public static function set_fallback_route($route) {
        self::$url = $route;
    }

    public static function handle($request);

    abstract public static function fallback() {
        HelperFuncs::redirect(self::$url);
    }
}


?>