<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id ID
 * @property string|null $city Населенный пункт
 * @property string|null $latitude Широта
 * @property string|null $longitude Долгота
 *
 * @property Users[] $users
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city'], 'string', 'max' => 70],
            [['latitude', 'longitude'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'Населенный пункт',
            'latitude' => 'Широта',
            'longitude' => 'Долгота',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['city_id' => 'id']);
    }

    /**
     * получение массива городов ['id категории' => 'Наименование города', ...]
     *
     * @return array
     */
    public static function getCitiesList() : array
    {
        return yii\helpers\ArrayHelper::map(Cities::find()->all(), 'id', 'city');
    }
}
