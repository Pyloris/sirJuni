<?php
// This file contains the Controller class
namespace sirJuni\Framework\Controller;

use sirJuni\Framework\Helper\HelperFuncs;

abstract class Controller {
    abstract public function show();
    abstract public function update();  
}