<?php
namespace sirJuni\Framework\Components;


class Request {
    private $store = [];

    public function fullUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    public function url() {
        return rtrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
    }

    public function addRouteHolder($key, $value) {
        $this->store[$key] = $value; 
    }

    public function getRouteValue($key) {
        return isset($this->store[$key]) ? $this->store[$key] : NULL;
    }

    public function getRouteKeys() {
        return array_keys($this->store);
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

    public function sessionData($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
    }

    public function sessionKeys() {
        return array_keys($_SESSION);
    }

    public function fileName($key) {
        return isset($_FILES[$key]["name"]) ? $_FILES[$key]["name"] : NULL;
    }

    public function File() {
        return isset($_FILES[$this->fileName()]["tmp_name"]) ? $_FILES[$this->fileName()]["tmp_name"] : NULL;
    }

    public function saveFile($path) {
        if (move_uploaded_file($_FILES[$this->fileName()]["tmp_name"], $path)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function fileMIME() {
        return isset($_FILES[$this->fileName()]["type"]) ? $_FILES[$this->fileName()]["type"] : NULL;
    }

    public function fileSize() {
        return isset($_FILES[$this->fileName()]["size"]) ? $_FILES[$this->fileName()]["size"] : NULL;
    }

    public function fileError() {
        return isset($_FILES[$this->fileName()]["error"]) ? $_FILES[$this->fileName()]["error"] : NULL;
    }
  
    public function allowedExtensions() {
            $ext = $_FILES[$this->getExtension()];
            $allowedTypes = ['jpg','jpeg','png','pdf'];
            return in_array($ext, $allowedTypes);
    }
    
    public function getExtension() {
            return isset($_FILES[$this->fileName()])? strtolower(end(explode('.',$_FILES[$this->fileName()]))):NULL;
    }

    public function generateFileId() {
            // this method generates a unique id/name for each file.
            return substr($_FILES[$this->fileName],0,7).uniqid('',true).".".$_FILES[$this->getExtension()];
    }
}

?>
