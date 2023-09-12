<?php
namespace sirJuni\Framework\Handler;


class Router {
    private static $routes = [];

    static public function handle($route, $query=NULL) {

        $default_method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($route, self::$routes)) {
            $controller = self::$routes[$route][$default_method][0];
            $handler = self::$routes[$route][$default_method][1];

            $contr = new $controller();
            $contr->{$handler}();
        }
        else {
            echo("DOES NOT EXIST");
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