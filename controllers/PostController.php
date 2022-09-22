<?php

namespace micro\controllers;

use yii\rest\ActiveController;

class PostController extends ActiveController
{
    public $modelClass = 'micro\models\Post';


    public function behaviors()
    {
        // remove rateLimiter which requires an authenticated user to work
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

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