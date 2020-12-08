<?php

class User {
    private $pdo, $isLoggedIn, $data;

    public function __construct($value = null) {
        $this->pdo = Database::getInstance();

        if($value) {
            $this->find($value);
            $this->isLoggedIn = true;
        } else {
            return false;
        }
    }

    public function login($email = null, $password = null, $remember = null) {
        if(!$email && !$password && $this->exists()) {
            Session::put(Config::get('session.session_user'), $this->data()->id);
        } else {
            if(isset($email)) {
                $user = $this->find($email);
                if ($user) {
                    if (password_verify($password, $this->data()->password)) {
                        $this->isLoggedIn = true;
                        Session::put(Config::get('session.session_user'), $this->data()->id);

                        if ($remember) {
                            $hash = hash('sha256', md5(uniqid()));

                            $checkUser = $this->pdo->get('users_cookie', ['user_id', '=', $this->data()->id]);
                            if (!$checkUser->count()) {
                                $this->pdo->insert('users_cookie', [
                                    'user_id' => $this->data()->id,
                                    'hash' => $hash
                                ]);
                            }

                            Cookie::put(Config::get('cookie.cookie_user'), $hash, Config::get('cookie.cookie_time'));
                        }
                    }
                }
            }
        }
        return $this;
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    public function find($value) {
        if (is_numeric($value)) {
            $this->data = $this->pdo->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->pdo->get('users', ['email', '=', $value])->first();
        }
        return $this;
    }

    public function data() {
        return $this->data;
    }

    public function hasPermission($key = null) {
        if($this->data) {
            $user = $this->pdo->get('groups', ['id', '=', $this->data()->group_id]);
            if($user->count()) {
                $userRole = json_decode($user->first()->role, true);
                if($userRole[$key]) {
                    return true;
                }
            }
        }
        return false;
    }

    public function update($id, $fiels = []) {
        return $this->pdo->update('users', $id, $fiels);
    }

    public function exists() {
        if(!empty($this->data())) {
            return true;
        }
        return false;
    }

    public function logout() {
        $this->pdo->delete('users_cookie', ['user_id', '=', Session::get(Config::get('session.session_user'))]);
        Cookie::delete(Config::get('cookie.cookie_user'));
        Session::delete(Config::get('session.session_user'));
    }

}