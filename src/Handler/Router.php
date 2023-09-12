<?php
namespace sirJuni\Framework\Handler;

use sirJuni\Framework\Helper\HelperFuncs;

class Router {
    private static $routes = [];

    static public function handle($route, $query=NULL) {

        $default_method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $pattern) {
            if (preg_match_all($pattern, HelperFuncs::trim_slash($route, 'end'))) {
                $controller = self::$routes[$pattern][$default_method][0];
                $handler = self::$routes[$pattern][$default_method][1];

                $contr = new $controller();
                $contr->{$handler}();
                exit(0);
            }
        }

        echo("ERROR ");
    }


    static public function add_route($method, $route, $handler) {

        // change path to regex
        // if placeholder is used
        // replace it with any regex (.*)$

        $route = preg_replace('/\{[a-zA-Z0-9]*\}(\/*||)$/', '[a-zA-Z0-9]*', $route);
        $route = '/' . preg_quote($route, '/') . '/';

        // add route            // handler = [controller, method]
        self::$routes[$route] = [
            $method => $handler
        ];
    }
}

?>