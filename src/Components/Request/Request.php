<?php
namespace sirJuni\Framework\Components\Request;

class Request {
    private $name;
    public function __construct($name) {
        $this->name = $name;
    }

    public function say() {
        echo($this->name);
    }
}

?>