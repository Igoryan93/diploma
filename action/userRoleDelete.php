<?php
require_once "../init.php";

$user = new User($_GET['id']);

if($user->data()->group_id == 2) {
    if(!Database::getInstance()->update('users', $user->data()->id, ['group_id' => 1])->error()) {
        Redirect::to('../edit_users.php');
        return true;
    }
    return false;
}
