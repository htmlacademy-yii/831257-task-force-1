<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use frontend\models\Users;
use frontend\models\Categories;
use frontend\models\UsersSearchForm;
use TaskForce\services\FilterUsers;


class UsersController extends SecuredController
{
    public function actionIndex()
    {
        //список категорий
        $cats = Categories::getCategoriesList();

        $model_form = new UsersSearchForm();
        $model_form->load(Yii::$app->request->post());
        $model_form->validate();

        //формирование запроса
        $query = Users::find()
        ->joinWith('categories')
        ->where(['is_builder' => 1]);

        //добавление фильтров
        $query = FilterUsers::getQuery($model_form, $query);

        $query->orderBy('date_add');

        $builders = $query->all();

        return $this->render('index', ['builders' => $builders, 'model' => $model_form, 'cats' => $cats]);
    }

    public function actionView(int $id)
    {
        //формирование запроса
        $query = Users::find()
        ->joinWith('city')
        ->joinWith('skills.category')
        ->joinWith('photos')
        ->joinWith('opinions.reviewAuthor opinionAuthor')
        ->joinWith('opinions.task')
        ->where(['users.id' => $id]);

        $user = $query->one();

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с ID $id не найден");
        }

        return $this->render('view', ['user' => $user]);
    }
}
