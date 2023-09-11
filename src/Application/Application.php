<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Helper\HelperFuncs;
use sirJuni\Framework\Handler\Router;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
abstract class Application {

    // hold the first part of url [it corresponds to controller to be used]
    public $controller = NULL;
    
    // hold the second url part [which corresponds to controller method to be called]
    public $handler = NULL;

    // store route parameters
    public $route_param = NULL;

    // to hold the query string parsed into assoc array
    public $query_str = NULL;

    public function __construct() {

        // split the url
        $this->splitURL();
    }

    // to split the url into parts
    private function splitURL() {
        $url = trim($_SERVER['REQUEST_URI']);

        // split the query string and path
        $url = explode("?", $url);

        // split the path
        $path = explode('/', trim($url[0]));

        // store the corresponding parts
        $this->controller = isset($path[0]) ? HelperFuncs::trim_slash(trim($path[0])) : NULL;
        $this->handler = isset($path[1]) ? HelperFuncs::trim_slash(trim($path[1])) : NULL;
        $this->route_param = isset($path[2]) ? HelperFuncs::trim_slash(trim($path[2])) : NULL;


        // if count($url) is > 1, then there are query params given
        if (count($url) > 1)
            parse_str(trim($url[1]), $this->query_str);             // parse string into associative array
    }


    abstract public function handler();
}

?>