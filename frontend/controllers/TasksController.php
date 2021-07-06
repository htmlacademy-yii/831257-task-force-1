<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\Tasks;
use frontend\models\Categories;
use frontend\models\TasksSearchForm;
use TaskForce\logic\TaskLogic;
use TaskForce\services\FilterTasks;

class TasksController extends Controller
{
    public function actionIndex()
    {
        //список категорий
        $cats = Categories::getCategoriesList();

        $model_form = new TasksSearchForm();
        $model_form->load(Yii::$app->request->post());
        $model_form->validate();

        //формирование запроса
        $query = Tasks::find()
        ->joinWith('category')
        ->joinWith('responses')
        ->where(['status' => TaskLogic::STATUS_NEW]);

        //добавление фильтров
        $query = FilterTasks::getQuery($model_form, $query);

        $query->orderBy('date_add');

        $tasks = $query->all();

        return $this->render('index', ['tasks' => $tasks, 'model' => $model_form, 'cats' => $cats]);
    }

    public function actionView(int $id)
    {
        //формирование запроса
        $query = Tasks::find()
        ->joinWith('category')
        ->joinWith('customer')
        ->joinWith('responses.user')
        ->joinWith('files')
        ->where(['tasks.id' => $id]);

        $task = $query->one();

        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }
        return $this->render('view', ['task' => $task]);
    }
}
