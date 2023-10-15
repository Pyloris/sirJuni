<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Components\Request;
use sirJuni\Framework\View\VIEW;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
class Application {
    public $request;

    public function __construct() {
        // create a new request context
        $this->request = new Request();

        // give the request context to the VIEW
        // it unpacks any dynamic url components
        VIEW::set_context($this->request);
    }

    public function handle() {
        Router::handle($this->request);
    }
}

?>