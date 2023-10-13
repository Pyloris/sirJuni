<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Components\Request;
use sirJuni\Framework\View\VIEW;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
class Application {
    public $request;

    public function __construct() {
        $this->request = new Request();
        VIEW::set_context($this->request);
    }
    
    public function handle() {
        Router::handle($this->request);
    }
}

?>