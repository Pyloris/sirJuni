<?php
namespace sirJuni\Framework\Handler\HandlerFuncs;


class Router {
    private static $routes;

    static public function get($route) {
        
        // include controllers
        // in handler file

        $default_method = 'GET';
        if (array_key_exists($routes, $route)) {
            $controller = $routes[$route][$default_method][0];
            $handler = $routes[$route][$default_method][1];

            $contr = new $controller();
            $contr->{$handler}();
        }
    }


    static public function post($route) {
        
        // include controllers
        // in handler file
        // include_every(CONTROLLER);

        $default_method = 'POST';
        if (array_key_exists($routes, $route)) {
            $controller = $routes[$route][$default_method][0];
            $handler = $routes[$route][$default_method][1];

            $contr = new $controller();
            $contr->{$handler}();
        }
    }


    static public function add_route($method, $route, $handler) {

        // add route            // handler = [controller, method]
        $routes[$route] = [
            $method => $handler
        ];
    }
}

?>