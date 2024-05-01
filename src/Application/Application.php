<?php
namespace sirJuni\Framework\Application;

use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Components\Request;
use sirJuni\Framework\View\VIEW;

// THIS CLASS CREATES A REQUEST INSTANCE
// GIVES VIEW ACCESS TO REQUEST
// AND HAS A METHOD TO FORWARD REQUEST TO Router.
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