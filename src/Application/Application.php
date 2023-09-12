<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Helper\HelperFuncs;
use sirJuni\Framework\Handler\Router;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
class Application {

    public $path = NULL;

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

        $this->path = $url[0];

        // if count($url) is > 1, then there are query params given
        if (count($url) > 1)
            parse_str(trim($url[1]), $this->query_str);             // parse string into associative array
    }


    public function submit() {
        Router::handle($this->path, $this->query_str);
    }
}

?>