<?php
namespace sirJuni\Framework\Components;

interface RequestAPI {
    public function fullUrl();
    public function url();
    public function method();
    public function queryData($key);
    public function queryKeys();
    public function formData($key);
    public function formKeys();
    public function cookieData($key);
    public function cookieKeys();
    public function addData($key, $value);
    public function getData($key);
}


class Request {
    private $store = [];

    public function fullUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    public function url() {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }

    public function addData($key, $value) {
        $this->store[$key] = $value; 
    }

    public function getData($key) {
        return isset($this->store[$key]) ? $this->store[$key] : NULL;
    }

    public function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function queryData($key) {
        return isset($_GET[$key]) ? $_GET[$key] : NULL;
    }

    public function queryKeys() {
        return array_keys($_GET);
    }

    public function formData($key) {
        return isset($_POST[$key]) ? $_POST[$key] : NULL;
    }

    public function formKeys() {
        return array_keys($_POST);
    }

    public function cookieData($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : NULL;
    }

    public function cookieKeys() {
        return array_keys($_COOKIE);
    }
}

?>