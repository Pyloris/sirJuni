<?php
namespace sirJuni\Framework\Middleware;

// Middleware should implement following methods
abstract class Middleware {
    abstract public static function set_fallback_route($route);
    abstract public static function handle($request);
    abstract public static function fallback();
}


?>