<?php
namespace sirJuni\Framework\Handler;

class Router {
    public static $routes = [];

    private static $error_handler = [];

    private static $last_path_saved = [];

    static public function handle($request) {

        $default_method = $request->method();

        $found = 0;

        foreach (self::$routes as $pattern=>$handler) {
            if (preg_match($pattern, $request->url(), $matches) and array_key_exists($default_method, $handler)) {
                $found = 1;
                // if there is a route match add it to request object
                foreach($matches as $name=>$value){
                    if ($name != 0)
                        $request->addRouteHolder($name, $value);
                }

                $controller = $handler[$default_method][0];
                $func = $handler[$default_method][1];
                $middleware = isset($handler[$default_method]['middleware']) ? $handler[$default_method]['middleware'] : NULL;

                if ($middleware){
                    if ($middleware::handle()) {
                        $contr = new $controller();
                        $contr->{$func}($request);
                    }
                }
                else {
                    $contr = new $controller();
                    $contr->{$func}($request);
                }
                exit();
            }
        }
        if ($found == 0) {
            self::serve_error($request);
        }
    }


    static public function add_route($method, $route, $handler) {

        $route = rtrim($route, '/');

        // get all the names of path placeholders
        preg_match_all('/\{(?<names>[a-zA-Z0-9]+)\}/', $route, $matches);
        $names = $matches['names'];
        
        // for each placeholder, replace it with regex for selection
        foreach($names as $key=>$value) {
            // replace the placeholder with alphanumeric regex with name same
            // as used in the route
            $route = preg_replace('/\{[a-zA-Z0-9]*\}/', "(?<$value>[a-zA-Z0-9]+)", $route, 1);
        }
        // make route into a regex
        $route = '/' . '^' . preg_replace('/\//', '\/', $route) . '$' . '/';

        // add route            // handler = [controller, method]
        self::$routes[$route] = [
            $method => $handler
        ];

        self::$last_path_saved[0] = [$route, $method];

        return new self();
    }


    public function middleware($middlewarefqcn) {

        // add the middleware to the last added route;
        self::$routes[self::$last_path_saved[0][0]][self::$last_path_saved[0][1]]['middleware'] = $middlewarefqcn;
    }


    static public function set_error_handler($FQCN, $callback) {
        // save the handler
        self::$error_handler = [$FQCN, $callback];
    }

    private static function serve_error($request) {
        // serve the error page
        $fqcn = self::$error_handler[0];
        $cb = self::$error_handler[1];

        $inst = new $fqcn();
        $inst->$cb($request);
    }
}

?>