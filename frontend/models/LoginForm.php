<?php

namespace frontend\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $person;

    public function rules()
    {
        $x=new Users();
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->person === null) {
            $this->person = Users::findOne(['email' => $this->email]);
        }

        return $this->person;
    }
}
