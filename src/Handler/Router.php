<?php
namespace sirJuni\Framework\Handler;

use sirJuni\Framework\Helper\HelperFuncs;

class Router {
    public static $routes = [];

    private static $error_handler = [];

    static public function handle($route, $query=NULL) {

        $default_method = $_SERVER['REQUEST_METHOD'];

        $found = 0;

        foreach (self::$routes as $pattern=>$handler) {
            if (preg_match_all($pattern, HelperFuncs::trim_slash($route, 'end'), $matches)) {
                $found = 1;
                $controller = $handler[$default_method][0];
                $func = $handler[$default_method][1];
                $middelware = isset($handler[$default_method]['middleware']) ? $handler[$default_method]['middleware'] : NULL;

                if ($middleware){
                    if ($middleware::handle()) {
                        $contr = new $controller();
                        $contr->{$func}(['name' => isset($matches[1]) ? $matches[1] : NULL]);
                    }
                }
                else {
                    $contr = new $controller();
                    $contr->{$func}(['name' => isset($matches[1]) ? $matches[1] : NULL]);
                }
                exit();
            }
        }
        if ($found == 0) {
            self::serve_error();
        }
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

        return new self();
    }


    public function middleware($middlewarefqcn) {

        $route_handlers = end(self::$routes);

        foreach($route_handlers as $handler) {
            $handler['middleware'] = $middlewarefqcn;
        }
    }


    static public function set_error_handler($FQCN, $callback) {
        // save the handler
        self::$error_handler = [$FQCN, $callback];
    }

    private static function serve_error() {
        // serve the error page
        $fqcn = self::$error_handler[0];
        $cb = self::$error_handler[1];

        $inst = new $fqcn();
        $inst->$cb();
    }
}

?>