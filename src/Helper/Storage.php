<?php
namespace sirJuni\Framework\Helper;


class Storage {

    public $keys = [];

    public static function addData($key, $value) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION[$key] = $value;
        session_write_close();
        array_push(self::$keys, $key);
    }

    public static function getData($key) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        if (isset($_SESSION[$key]) and boolval(array_search($key, self::$keys)+1)){
            session_write_close();
            return $_SESSION[$key];
        }
        else{
            session_write_close();
            return NULL;
        }
    }

    public static function dump() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $data = [];
        foreach(self::$keys as $key)
            $data[$key] = $_SESSION[$key];
        session_write_close();
    
        return $data;
    }

    public static function addBucket($arr) {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        foreach($arr as $key=>$value) {
            array_push(self::$keys, $key);
            $_SESSION[$key] = $value;
        }
        session_write_close();
    }

    public static function release() {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        foreach(self::$keys as $key) {
            unset($_SESSION[$key]);
        }
        session_write_close();
    }
}
?>