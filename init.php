<?php
session_start();

require_once "classes/Database.php";
require_once "classes/Input.php";
require_once "classes/Token.php";
require_once "classes/Config.php";
require_once "classes/Session.php";
require_once "classes/Validation.php";
require_once "classes/Redirect.php";
require_once "classes/User.php";
require_once "classes/Cookie.php";

$GLOBALS['config'] = [
    'mysql' => [
        'host'     => 'localhost',
        'database' => 'registration2',
        'username' => 'root',
        'password' => 'root'

    ],
    'session' => [
        'session_token' => 'token',
        'session_user'  => 'user'
    ],
    'cookie' => [
        'cookie_user' => 'hash',
        'cookie_time' => 6000
    ]
];

if(Cookie::exists(Config::get('cookie.cookie_user'))) {
    $hashName = Cookie::get(Config::get('cookie.cookie_user'));
    $hash = Database::getInstance()->get('users_cookie', ['hash', '=', $hashName]);
    if($hash->count()) {
        $user = new User($hash->first()->user_id);
        $user->login();
    }
}