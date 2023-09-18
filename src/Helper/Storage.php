<?php
namespace sirJuni\Framework\Helper;


class Storage {

    public $keys = [];

    public static function addData($key, $value) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION[$key] = $value;
        array_push(self::$keys, $key);
    }

    public static function getData($key) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        if (isset($_SESSION[$key]) and boolval(array_search($key, self::$keys)+1))
            return $_SESSION[$key];
        else
            return NULL;
    }

    public static function dump() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $data = [];
        foreach(self::$keys as $key)
            $data[$key] = $_SESSION[$key];
        return $data;
    }

    public static function addBucket($arr) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        foreach($arr as $key=>$value) {
            array_push(self::$keys, $key);
            $_SESSION[$key] = $value;
        }
    }
}
?>