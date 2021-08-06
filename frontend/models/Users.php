<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id ID
 * @property string $email Электронная почта
 * @property string $login Логин
 * @property string $password Пароль
 * @property string|null $date_add Дата создания аккаунта
 * @property int $city_id id населенного пункта
 * @property string|null $avatar Аватар
 * @property string|null $birthday Дата рождения
 * @property string|null $about_me О пользователе
 * @property string|null $phone Телефон
 * @property string|null $skype Skype
 * @property string|null $telegram Telegram
 * @property string|null $raiting Рейтинг
 * @property string|null $last_activity Дата последней активности
 * @property int|null $is_builder Признак испольнителя
 * @property int|null $new_message Новое сообщение
 * @property int|null $task_actions Действия по заданию
 * @property int|null $new_review Новый отзыв
 * @property int|null $show_my_contacts Показывать мои контакты только заказчику
 * @property int|null $not_show_my_profile Не показывать мой профиль
 * @property int $tasks_count Количество выполненных заданий
 * @property int $opinions_count Количество отзывов
 *
 * @property Favorites[] $favorites
 * @property Favorites[] $favorites0
 * @property Messages[] $messages
 * @property Opinions[] $opinions
 * @property Opinions[] $opinions0
 * @property Photos[] $photos
 * @property Responses[] $responses
 * @property Skills[] $skills
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property Cities $city
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return '{{%user}}';
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'login', 'password', 'city_id'], 'required'],
            [['date_add', 'birthday', 'last_activity'], 'safe'],
            [['city_id', 'is_builder', 'new_message', 'task_actions', 'new_review', 'show_my_contacts', 'not_show_my_profile', 'tasks_count', 'opinions_count'], 'integer'],
            ['about_me', 'string'],

            ['email', 'string', 'max' => 320],
            ['email', 'email'],
            ['email', 'unique'],

            [['login', 'avatar'], 'string', 'max' => 70],

            ['password', 'string', 'min' => 8, 'max' => 255],

            ['phone', 'string', 'max' => 11],
            ['phone', 'match', 'pattern' => '/^[\d]{11}/i',
            'message' => 'Номер телефона должен состоять из 11 цифр'],

            [['skype', 'telegram'], 'string', 'max' => 45],
            [['raiting'], 'string', 'max' => 4],

            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
//        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
//        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Электронная почта',
            'login' => 'Логин',
            'password' => 'Пароль',
            'date_add' => 'Дата создания аккаунта',
            'city_id' => 'id населенного пункта',
            'avatar' => 'Аватар',
            'birthday' => 'Дата рождения',
            'about_me' => 'О пользователе',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'raiting' => 'Рейтинг',
            'last_activity' => 'Дата последней активности',
            'is_builder' => 'Признак испольнителя',
            'new_message' => 'Новое сообщение',
            'task_actions' => 'Действия по заданию',
            'new_review' => 'Новый отзыв',
            'show_my_contacts' => 'Показывать мои контакты только заказчику',
            'not_show_my_profile' => 'Не показывать мой профиль',
            'tasks_count' => 'Количество выполненных заданий',
            'opinions_count' => 'Количество отзывов',
        ];
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::className(), ['user_id_customer' => 'id']);
    }

    /**
     * Gets query for [[Favorites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorites::className(), ['user_id_builder' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinionsAuthor()
    {
        return $this->hasMany(Opinions::className(), ['review_author_id' => 'id']);
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photos::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('skills', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['builder_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Skills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skills::className(), ['user_id' => 'id']);
    }

    /**
     * Получить интервал между датой последней активности пользователя и текущей датой
     *
     * @return string
     */
    public function getPeriodLastVizit() : string
    {
        // в БД дата хранится в UTC
        $tz = new \DateTimeZone('UTC');

        $date_last = is_null($this->last_activity) ? $this->date_add : $this->last_activity;

        $date = new \DateTime($date_last, $tz);

        $interval = Yii::$app->formatter->asRelativeTime($date);

        return $interval;
    }

    /**
     * Получить интервал между датой регистрации пользователя и текущей датой, вида "2 месяца назад"
     *
     * @param bool $ending Нужно ли возвращать в конце строки слово "назад"
     *
     * @return string
     */
    public function getPeriodCreate(bool $ending = true) : string
    {
        // в БД дата хранится в UTC
        $tz = new \DateTimeZone('UTC');

        $date = new \DateTime($this->date_add, $tz);

        $interval = Yii::$app->formatter->asRelativeTime($date);

        return $ending ? $interval : mb_substr($interval, 0, mb_strlen($interval) - 6);
    }

    /**
     * Получить возраст пользователя
     *
     * @return string
     */
    public function getAge() : string
    {
        // в БД дата хранится в UTC
        $tz = new \DateTimeZone('UTC');

        $date = new \DateTime($this->birthday, $tz);

        $date_now = new \DateTime();

        $interval=$date->diff($date_now);

        return $interval->y;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
