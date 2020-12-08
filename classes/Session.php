<?php

class Session {

    public static function put($name, $value) {
        if (isset($name)) {
            return $_SESSION[$name] = $value;
        }
        return false;
    }

    public static function exists($name) {
        if (self::get($name)) {
            return true;
        }
        return false;
    }

    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
        return false;
    }

    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function flash($name, $value = null) {
        if(Session::exists($name) && Session::get($name)) {
            $message = self::get($name);
            self::delete($name);
            return $message;
        } else {
            self::put($name, $value);
        }
    }

}