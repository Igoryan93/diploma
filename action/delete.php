<?php
require_once "../init.php";

$user = new User($_GET['id']);

if($user->data()) {
    if(!Database::getInstance()->delete('users', ['id', '=', $user->data()->id])->error()) {
        Redirect::to('../edit_users.php');
        return true;
    }
    return false;
}
