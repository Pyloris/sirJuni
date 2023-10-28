<?php
namespace sirJuni\Framework\Middleware;

use sirJuni\Framework\Helper\HelperFuncs;

// THIS IS A BUILTIN MIDDLEWARE
// If a request is passed through this middleware
// it checks if user is authenticated and returns corresponding boolean
class Auth {

    // store the fallback url in case login:check fails
    public static $url;

    // set the fallback url
    public static function set_fallback_route($url) {
        self::$url = $url;
    }

    // login the user whose details are in $data array
    public static function login($data) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        foreach($data as $key => $value) {
            $_SESSION[$key] = $value;
        } 
        $_SESSION['auth'] = 'true';
        session_write_close();
    }

    // logout the user by destroying the session
    // and unsetting session variables
    public static function logout() {
        if (Auth::check()){
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            session_destroy();
            foreach($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            session_write_close();
        }
    }

    // check if user is logged in or not
    public static function check() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['auth']) ? TRUE : FALSE;
    }


    // this method should be called when check() fails to
    // send user to fallback url
    public static function fallback() {
        HelperFuncs::redirect(self::$url);
    }


    public static function handle($request) {
        // if false, call the fallback() method
        return self::check();
    }
}

?>