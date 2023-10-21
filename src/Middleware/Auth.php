<?php
namespace sirJuni\Framework\Middleware;

use sirJuni\Framework\Helper\HelperFuncs;


class Auth {

    public static $url;

    public static function set_fallback_route($url) {
        self::$url = $url;
    }

    public static function login($data) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        foreach($data as $key => $value) {
            $_SESSION[$key] = $value;
        } 
        $_SESSION['auth'] = 'true';
        session_write_close();
    }

    public static function logout() {
        if (Auth::check()){
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            session_destroy();
            foreach($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            unset($_SESSION['auth']);
            session_write_close();
        }
    }

    public static function check() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['auth']) ? TRUE : FALSE;
    }

    public static function handle($request) {
        if (!self::check()) {
            HelperFuncs::redirect(self::$url);
        }
        // let the router handle the request
        return TRUE;
    }
}

?>