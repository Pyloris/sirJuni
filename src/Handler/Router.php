<?php
namespace sirJuni\Framework\Handler;

use sirJuni\Framework\Helper\HelperFuncs;

class Router {
    public static $routes = [];

    static public function handle($route, $query=NULL) {

        $default_method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $pattern=>$handler) {
            if (preg_match_all($pattern, HelperFuncs::trim_slash($route, 'end'), $matches)) {
                $controller = $handler[$default_method][0];
                $func = $handler[$default_method][1];

                $contr = new $controller();
                $contr->{$func}(isset($matches[1]) ? $matches[1] : NULL);
                exit(0);
            }
        }

        echo("ERROR ");
    }


    static public function add_route($method, $route, $handler) {

        // change path to regex
        // if placeholder is used
        // replace it with any regex (.*)$

        $route = preg_replace('/\{[a-zA-Z0-9]*\}(\/*||)$/', '([a-zA-Z0-9]*)', $route);
        $route = '/' . preg_replace('/\//', '\/', $route) . '/';

        // add route            // handler = [controller, method]
        self::$routes[$route] = [
            $method => $handler
        ];
    }
}

?>