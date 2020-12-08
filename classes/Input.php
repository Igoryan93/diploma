<?php

class Input {

    public static function exists($type) {
        if ($type == $_POST || $type == $_GET) {
            switch ($type) {
                case $_POST : {
                    return (isset($_POST)) ? true : false;
                }
                case $_GET : {
                    return (isset($_GET)) ? true : false;
                }
                default: {
                    return false;
                }
            }
        }
        return false;
    }

    public static function get($name) {
        if(isset($name)) {
            if(isset($_POST)) {
                return $_POST[$name];
            } else if(isset($_GET)) {
                return $_GET[$name];
            }
        }
        return false;
    }

}