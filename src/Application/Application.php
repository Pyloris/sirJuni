<?php
namespace sirJuni\Framework\Application;

use function sirJuni\Framework\Helper\trim_slash;
use sirJuni\Framework\Handler\Router;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
class Application {

    // hold the first part of url [it corresponds to controller to be used]
    private $controller = NULL;
    
    // hold the second url part [which corresponds to controller method to be called]
    private $handler = NULL;

    // store route parameters
    private $route_param = NULL;

    // to hold the query string parsed into assoc array
    private $query_str = NULL;

    public function __construct() {

        // split the url
        $this->splitURL();

        // there should be a CONTROLLER CONSTANT
        // that points to controllers.php directory
        Router::get("/$controller");

        // create an instance of corresponding controller
        // there should be a path->controller mapping in controllers.php
        // by the name of controllerMap
        // $controller = new controllerMap[$this->controller]();

        // there should be a path to handler
        // $controller->{$this->handler}($route_param);
    }

    // to split the url into parts
    private function splitURL() {
        $url = trim($_SERVER['REQUEST_URI']);

        // split the query string and path
        $url = explode("?", $url);

        // split the path
        $path = explode('/', trim($url[0]));

        // store the corresponding parts
        $this->controller = isset($path[0]) ? trim_slash(trim($path[0])) : NULL;
        $this->handler = isset($path[1]) ? trim_slash(trim($path[1])) : NULL;
        $this->route_param = isset($path[2]) ? trim_slash(trim($path[2])) : NULL;


        // if count($url) is > 1, then there are query params given
        if (count(url) > 1)
            parse_str(trim($url[1]), $this->query_str);             // parse string into associative array
    }
}

?>