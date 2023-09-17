<?php

namespace sirJuni\Framework\Controller;

abstract class Controller {
    abstract public function index($request);
    abstract public function show($request);
    abstract public function create($request);
    abstract public function store($request);
    abstract public function delete($request);
}

?>