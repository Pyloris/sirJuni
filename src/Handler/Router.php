<?php
namespace sirJuni\Framework\Handler;


class Router {
    private static $routes = [];

    static public function get($route) {
        
        // include controllers
        // in handler file

        $default_method = 'GET';
        if (array_key_exists($route, self::$routes)) {
            $controller = self::$routes[$route][$default_method][0];
            $handler = self::$routes[$route][$default_method][1];

            $contr = new $controller();
            $contr->{$handler}();
            echo("HELLO");
        }
        else {
            echo("WRONG BUDDY");
        }
    }


    static public function post($route) {
        
        // include controllers
        // in handler file
        // include_every(CONTROLLER);

        $default_method = 'POST';
        if (array_key_exists($route, self::$routes)) {
            $controller = self::$routes[$route][$default_method][0];
            $handler = self::$routes[$route][$default_method][1];

            $contr = new $controller();
            $contr->{$handler}();
        }
    }


    static public function add_route($method, $route, $handler) {

        // add route            // handler = [controller, method]
        self::$routes[$route] = [
            $method => $handler
        ];
    }
}

?>