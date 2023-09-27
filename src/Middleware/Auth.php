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
        $_SESSION['userid'] = $data['id'];
        $_SESSION['username'] = $data['name'];
        $_SESSION['user_email'] = $data['email'];
        session_write_close();
    }

    public static function logout() {
        if (Auth::check()){
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            session_destroy();
            unset($_SESSION['userid']);
            unset($_SESSION['username']);
            unset($_SESSION['user_email']);
            session_write_close();
        }
    }

    public static function check() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['userid']) ? TRUE : FALSE;
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