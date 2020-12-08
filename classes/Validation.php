<?php

class Validation {
    private $error = [], $passed = false;

    public function check($source, $fields = []) {
        foreach ($fields as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = $source[$item];
                if($rule === 'required' && (empty($value))) {
                    $this->addError("Поле {$this->field($item)} обязательно для заполнения!");
                } else if(!empty($value)) {
                    switch ($rule) {
                        case 'min' : {
                            if(strlen($value) < $rule_value) {
                                $this->addError("Поле {$this->field($item)} должно иметь минимум {$rule_value} символа!");
                            }
                        } break;
                        case 'max' : {
                            if(strlen($value) > $rule_value) {
                                $this->addError("Поле {$this->field($item)} не должно превышать {$rule_value} символов!");
                            } break;
                        }
                        case 'unique' : {
                            $user = Database::getInstance()->get($rule_value, [$item, '=', $value]);
                            if($user->result()) {
                                $this->addError("Пользователь с E-mail-м {$value} уже существует!");
                            }
                        } break;
                        case 'email' : {
                            if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("Поле {$this->field($item)} не коррекно");
                            }
                        } break;
                        case 'matches' : {
                            if($value !== $source[$rule_value]) {
                                $this->addError("Поле {$this->field($rule_value)} и {$this->field($item)} не совпадают");
                            }
                        } break;
                    }
                }
            }
        }

        if(!$this->error()) {
            $this->passed = true;
        }

        return $this;

    }

    public function addError($error) {
        return $this->error[] = $error;
    }

    public function error() {
        return $this->error;
    }

    public function passed() {
        return $this->passed;
    }
    public function field($item) {
        switch ($item) {
            case 'email' : {
                return $item = 'E-mail';
            } break;
            case 'username' : {
               return $item = 'Имя';
            } break;
            case 'password' : {
                return $item = 'Пароль';
            } break;
            case 'password_again' : {
                return  $item = 'Повторите пароль';
            } break;
            case 'new_password' : {
                return $item = 'Новый пароль';
            } break;
            case 'agree' : {
                return $item = 'Подтверждение о согласии с правилами';
            } break;
        }
        return false;
    }

}