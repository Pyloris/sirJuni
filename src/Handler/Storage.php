<?php
namespace sirJuni\Framework\Handler;


class Storage {

    public static function addData($key, $value) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION[$key] = $value;
    }

    public static function getData($key) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return NULL;
    }

    public static function dump() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $data = [];
        foreach($_SESSION as $key=>$value)
            $data[$key] = $value;
        return $data;
    }

    public static function addBucket($arr) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        foreach($arr as $key=>$value) {
            $_SESSION[$key] = $value;
        }
    }
}
?>