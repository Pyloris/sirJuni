<?php
namespace sirJuni\Framework\Middleware;

use sirJuni\Framework\Helper\HelperFuncs;


class Auth {

    public static $url;

    public static function set_auth_url($url) {
        self::$url = $url;
    }

    public static function login($data) {
        session_start();
        $_SESSION['userid'] = $data['id'];
        $_SESSION['username'] = $data['name'];
        $_SESSION['user_email'] = $data['email'];
    }

    public static function logout() {
        session_destroy();
        unset($_SESSION['userid']);
        unset($_SESSION['username']);
        unset($_SESSION['user_email']);
    }

    public static function check() {
        session_start();
        return isset($_SESSION['userid']) ? TRUE : FALSE;
    }

    public static function handle() {
        if (!self::check()) {
            HelperFuncs::redirect($url);
        }
        // let the router handle the request
        return TRUE;
    }
}

?>