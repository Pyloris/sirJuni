<?php
namespace sirJuni\Framework\Handler;


// Handles Routing. It takes the request from Application instance and forwards it to proper handlers
class Router {
    // stores all the routes as an assoc array : Handlers are keyed to Path
    public static $routes = [];

    // stores the error handler
    private static $error_handler = NULL;

    // it stores the last path added temporarily
    // it is used by middleware function to set middleware on a route
    // by accessing the last path added, then adding middleware attribute to it
    private static $last_path_saved = NULL;

    
    // storing the path to _templates folder
    // which contains all the necessary html
    private static $path = __DIR__ . "\\..\\_templates\\";

    static public function handle($request) {

        // if no routes have been added
        // display a default index page
        if (empty(self::$routes)) {
            // render default page
            include(self::$path . "default.html");
            exit();
        }

        // grab the method of the request
        $req_method = $request->method();

        // flag: set when a match for a route is found.
        $found = 0;

        // match the current route with every pattern inside of the $route variable
        foreach (self::$routes as $pattern => $handler) {
            // pattern : it is the regex of path added when add_route is called
            // handler : it is an array containing the Controller FQCN and method to handle request

            // match the current URL against the pattern
            // and check if the Method of request is supported for this URL.
            if (preg_match($pattern, $request->url(), $matches) and array_key_exists($req_method, $handler)) {
                
                // if the match is found: set flag
                $found = 1;

                // get the FQCN of Controller
                $controller = $handler[$req_method][0];

                // get the handler function
                $handler_func = $handler[$req_method][1];

                // get the middleware class FQCN if it is set
                $middleware = $handler[$req_method]['middleware'];

                break;
            }
            
            // if a match if found : flag=1 - break loop
            if ($found)
                break;
        }


        // if there is no match for route
        // serve up the error page
        if ($found == 0) {
            if (!self::$error_handler) {
                $path = $request->url();
                // render default error page
                include(self::$path . "404.html");
                exit();
            }
            else {
                self::serve_error($request);
                exit();
            }
        }


        // this part of code deals with extracting any placeholder values
        // It is executed if there are {xxx} placeholders placed while defining URL
        // using add_route static method of this class.
        foreach($matches as $name=>$value){
            $request->addRouteHolder($name, $value);
        }



        // check if there are any middleware's set
        $is_mdw_set = count($middleware);       // returns > 0 if there are any
       
        
        // if mdw is not set, just send the request to controller
        if (!$is_mdw_set) {

            // request is simply passed on to the Controller to handle
            $contr = new $controller();
            $contr->$handler_func($request);
            exit();
        }


        // route request through all middlewares as middleware is set
        foreach($middleware as $mdw) {
            // becomes false even if 1 middleware fails
            $SUCCESS = $mdw::handle($request);
            
            if (!$SUCCESS)
                break;
        }

        // if all middlewares pass the route the request to the controller
        if ($SUCCESS) {
            $cont = new $controller();
            $cont->$handler_func($request);
        } 
    }


    // Add a route to the $route assoc array
    static public function add_route($method, $route, $handler) {

        // for consistancy remove rightmost / from URL
        $route = rtrim($route, '/');

        // grab the name:type groups using regex

        $name_pattern = '/(?<=\{)(?<names>[a-zA-Z0-9]+)((?=:)|)/';
        $type_pattern = '/(?<=:)(?<types>[a-zA-Z0-9]+)/';

        // default the missing datatypes to string
        $name_only_pattern = '/(?<=\{)(?<name_only>[a-zA-Z0-9]+)(?=\})/';

        // replace these names with default string types
        preg_match_all($name_only_pattern, $route, $name_only);
        foreach($name_only as $key => $value){
            preg_replace($name_only_pattern, "{$value:string}", $route, 1);
        }

        preg_match_all($name_pattern, $route, $names_matches);
        preg_match_all($type_pattern, $route, $types_matches);

        $names = $names_matches['names'];
        $types = $types_matches['types'] ?? NULL;

        foreach($names as $key=>$value) { 

            // replace the placeholder with alphanumeric regex with name same
            // as used in the route
            if (!$types) {
                $target = '/\{[a-zA-Z0-9]+\}/';
                $insert_pattern = "(?<$value>[a-zA-Z0-9]+)";
            }
            else if ($types[$key] == 'string'){
                $target = '/\{[a-zA-Z0-9]+:[a-zA-Z0-9]+\}/';
                $insert_pattern = "(?<$value>[a-zA-Z0-9]+)";
            }
            else if ($types[$key] == 'path') {
                $target = '/\{[a-zA-Z0-9]+:[a-zA-Z0-9]+\}/';
                $insert_pattern = "(?<$value>[a-zA-Z0-9/]+)";
            }
            else if ($types[$key] == 'int') {
                $target = '/\{\w+:\w+\}/';
                $insert_pattern = "(?<$value>\d+)";
            }

            $route = preg_replace($target, $insert_pattern, $route, 1);
        }

        // make route into a regex
        $route = '/' . '^' . preg_replace('/\//', '\/', $route) . '$' . '/';

        // add route            // handler = [controller, method]
        // in the handler set space for middleware by creating an array
        $handler['middleware'] = [];
        self::$routes[$route] = [
            $method => $handler
        ];
        
        // aslo save current route for use by middleware attachment
        self::$last_path_saved = [$route, $method];


        // return an instance of this class, so that middleware method can be chained with this method
        return new self();
    }


    public function middleware($middlewarefqcn) {
        
        if (self::$last_path_saved){
            // add the middleware to the last added route;
            self::$routes[self::$last_path_saved[0]][self::$last_path_saved[1]]['middleware'][] = $middlewarefqcn;
        }
        else {
            // render custom error page
            $issue = "Wrong middleware() function call";
            $message = "Expected a route to have been added before a call to Router->middleware() function";
            include(self::$path . "custom_error.html");
            exit();
        }
        
        return $this;
    }


    static public function set_error_handler($FQCN, $callback) {
        // save the handler
        self::$error_handler = [$FQCN, $callback];
    }

    private static function serve_error($request) {
        // serve the error page
        // check if controller is set
        $fqcn = self::$error_handler[0];
        $cb = self::$error_handler[1];

        $inst = new $fqcn();
        $inst->$cb($request);
    }
}

?>