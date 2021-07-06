<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\SignupForm;

class SignupController extends Controller
{
    public function actionCreate() {

        $user_new = new SignupForm();

        if (!Yii::$app->request->getIsPost()) {
            $user_new->validate(['city_id', 'cities_list']);
        } else {
            $user_new->load(Yii::$app->request->post());

//            if (!$user->validate()) {
//                $errors = $user->getErrors();
//            }
//            if (Yii::$app->request->isAjax) {
//                return ActiveForm::validate($user_new);
//            }

            if ($user_new->validate()) {
                // выполнить сохранение формы в БД
                $user_new->signup();
                $this->goHome();
            }
        }
        return $this->render('index', ['model' => $user_new]);
    }
}
