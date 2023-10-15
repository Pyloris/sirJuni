<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Components\Request;
use sirJuni\Framework\View\VIEW;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
class Application {
    public $request;

    public function __construct($root='/') {
        // create a new request context
        $this->request = new Request();

        // give the request context to the VIEW
        // it unpacks any dynamic url components
        VIEW::set_context($this->request);

        // set the website root, provided from application constructor arg
        // if root is other than '/', it will be added to router for rendering
        // templates that come along with framwork.
        Router::set_root($root);
    }
    
    public function handle() {
        Router::handle($this->request);
    }
}

?>