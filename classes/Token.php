<?php
class Token {

    public static function generate() {
        return Session::put(Config::get('session.session_token'), md5(uniqid()));
    }

    public static function exists($token) {
        $tokenName = Config::get('session.session_token');

        if(Session::get($tokenName) === $token && Session::exists($tokenName)) {
            Session::delete($tokenName);
            return true;
        }

        return false;

    }
}