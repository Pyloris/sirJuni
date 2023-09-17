<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Components\Request;

// APPLICATION MATCHES MATCHES ROUTES TO PROPER HANDLERS
class Application {
    public $request;

    public function __construct() {
        $this->request = new Request();
    }
    
    public function submit() {
        Router::handle($this->request);
    }
}

?>