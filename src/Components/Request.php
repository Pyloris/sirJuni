<?php
namespace sirJuni\Framework\Components;


// THIS CLASS IS A LOGICAL ABSTRACTION OF REQUEST
// IT PROVIDES AN API TO WORK WITH REQUEST RELATED DATA
class Request {

    // an array that stores the dynamic url parts
    // if there are any
    // it is only persistant inter-request - it does not persist between requests.
    private $store = [];


    // return full URL including query string if there is any
    public function fullUrl() {
        return $_SERVER['REQUEST_URI'];
    }


    // returns PATH visited without query string
    public function url() {
        return rtrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
    }


    // this function is used to add a dyanmic url part and store it in $store.
    // it is extracted by the VIEW class to provide access to dyanmic url parts
    // as variables in the context of html page being rendered.
    public function addRouteHolder($key, $value) {
        $this->store[$key] = $value; 
    }

    // to get the corresponding value to given key, retreive the store dynamic parts
    public function getRouteValue($key) {
        return isset($this->store[$key]) ? $this->store[$key] : NULL;
    }

    // get all the keys in $store array
    public function getRouteKeys() {
        return array_keys($this->store);
    }


    // returns the method of the REQUEST like GET, POST
    public function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    // returns data from $_GET array given the $key
    public function queryData($key) {
        return isset($_GET[$key]) ? $_GET[$key] : NULL;
    }

    // get all keys in $_GET
    public function queryKeys() {
        return array_keys($_GET);
    }

    
    // return data to corresponding $key in $_POST
    public function formData($key) {
        return isset($_POST[$key]) ? $_POST[$key] : NULL;
    }


    // return all the form keys
    public function formKeys() {
        return array_keys($_POST);
    }

    // return data from the $_COOKIE
    public function cookieData($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : NULL;
    }

    // return all the keys of $_COOKIE
    public function cookieKeys() {
        return array_keys($_COOKIE);
    }


    // get data in $_SESSION : make sure session is started before calling this.
    public function sessionData($key) {
        // make sure session is running
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
    }


    // get all the session keys
    public function sessionKeys() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        return array_keys($_SESSION);
    }

    // get the name of uploaded file
    public function fileName($key) {
        return isset($_FILES[$key]["name"]) ? $_FILES[$key]["name"] : NULL;
    }


    // get the path to the tmp file where the uploaded file is saved
    public function File($key) {
        return isset($_FILES[$key]["tmp_name"]) ? $_FILES[$key]["tmp_name"] : NULL;
    }

    // get the MIME type of file
    public function fileMIME($key) {
        return isset($_FILES[$key]["type"]) ? $_FILES[$key]["type"] : NULL;
    }

    // get the size of the uploaded file
    public function fileSize($key) {
        return isset($_FILES[$key]["size"]) ? $_FILES[$key]["size"] : NULL;
    }

    // get the error code corresponding to file upload
    public function fileError($key) {
        return isset($_FILES[$key]["error"]) ? $_FILES[$key]["error"] : NULL;
    }
    
    // get the extension of the file if it has any: otherwise return NULL
    public function fileExtension($key) {
        // get the file name
        $name = $this->fileName($key);

        if ($name) {
            $split_name = explode('.', $name);

            if (count($split_name) > 1) {
                return strtolower(end($split_name));
            }
            else {
                return NULL;
            }
        }
        else {
            return NULL;
        }
    }
}

?>
