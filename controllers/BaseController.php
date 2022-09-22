<?php

namespace micro\controllers;
use yii\rest\ActiveController;

class BaseController extends ActiveController {

    public $modelClass = 'micro\models\Post';
    
    public function behaviors() {

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


}