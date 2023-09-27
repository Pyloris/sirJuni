<?php
namespace sirJuni\Framework\Middleware;


abstract class Middleware {
    abstract public static function set_fallback_route($route);
    abstract public static function handle($request);
}


?>