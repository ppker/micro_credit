<?php

namespace micro\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'micro\models\User';

    public function actions() {

        return [];
    }


    public function verbs() {

        return [];
    }

    public function actionHi() {

        return ['code' => 0, 'message' => 'ok'];
    }

}