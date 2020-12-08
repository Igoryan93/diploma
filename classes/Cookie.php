<?php
class Cookie {
    public static function put($name, $hash, $time) {
        setcookie($name, $hash, time() + $time, '/');
    }

    public static function exists($name) {
        if(isset($name)) {
            return ($_COOKIE[$name]) ? true : false;
        }
    }

    public static function delete($name) {
        if(self::exists($name)) {
            return setcookie($name, '', time() - 1);
        }
    }

    public static function get($name) {
        return $_COOKIE[$name];
    }
}