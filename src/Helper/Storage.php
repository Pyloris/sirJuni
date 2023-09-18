<?php
namespace sirJuni\Framework\Helper;

class Storage {

    // initiate key storage
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['key_store'] = [];
        session_write_close();
    }

    public static function addData($key, $value) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$key] = $value;
        $_SESSION['key_store'][] = $key;
        session_write_close();
    }

    public static function getData($key) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION[$key]) && in_array($key, $_SESSION['key_store'])) { // Use in_array to check if key exists in the array
            session_write_close();
            return $_SESSION[$key];
        } else {
            session_write_close();
            return NULL;
        }
    }

    public static function dump() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $data = [];
        foreach ($_SESSION['key_store'] as $key) {
            $data[$key] = $_SESSION[$key];
        }
        session_write_close();

        return $data;
    }

    public static function addBucket($arr) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        foreach ($arr as $key => $value) {
            $_SESSION['key_store'][] = $key;
            $_SESSION[$key] = $value;
        }
        session_write_close();
    }

    public static function release() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        foreach ($_SESSION['key_store'] as $key) {
            unset($_SESSION[$key]);
        }
        $_SESSION['key_store'] = [];
        session_write_close();
    }
}
?>
