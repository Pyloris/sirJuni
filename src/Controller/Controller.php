<?php

namespace sirJuni\Framework\Controller;

abstract class Controller {
    abstract public function index($request, $data);
    abstract public function update($request, $data);
}

?>