<?php
session_start();
require_once "init.php";

Session::flash('success', true);
Redirect::to('profile.php?id=' . $_GET['id']);