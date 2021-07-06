<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $login;
    public $password;

    /**
     * @var string $cities_list Массив городов, ключ - id города, значение - наименование города
     */
    public $cities_list;

    /**
     * @var string $city_id id города
     */
    public $city_id;

    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required', 'message' => "Введите ваше имя и фамилию"],
            ['login', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'Такое имя пользователя уже существует.'],
            ['login', 'string', 'min' => 2, 'max' => 70, 'tooShort' => "Длина имени от 2 символов", 'tooLong' => "Длина имени до 70 символов"],

            ['email', 'trim'],
            ['email', 'required', 'message' => "Введите адрес электронной почты"],
            ['email', 'email', 'message' => "Введите валидный адрес электронной почты"],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'Такой email уже существует.'],

            ['password', 'required', 'message' => "Введите пароль"],
            ['password', 'string', 'min' => 8, 'max' => 255, 'tooShort' => "Длина пароля от 8 символов", 'tooLong' => "Длина пароля до 255 символов"],

            ['cities_list', 'default', 'value' => Cities::getCitiesList()],
            ['city_id', 'default', 'value' => 1],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool
     */
    public function signup() : bool
    {
        $user = new Users();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->city_id = $this->city_id;
        $user->setPassword($this->password);

        // в БД дата хранится в UTC
        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $user->date_add = $date->format('Y-m-d H:i:s');

        return $user->save();
    }
}
