<?php
class Config {

    public static function get($paths) {
        if($paths) {
            $config = $GLOBALS['config'];
            $paths = explode('.', $paths);

            foreach ($paths as $path) {
                $config = $config[$path];
            }

            return $config;
        }
        return false;
    }

}