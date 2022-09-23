<?php

namespace micro\controllers;
use yii\rest\ActiveController;
use abei2017\wx\Application;

class BaseController extends ActiveController {

    public $modelClass = 'micro\models\Post';
    
    public $wx = null;

    public function init() {

        parent::init();
        $conf = \Yii::$app->params['wx']['mp'];
        $this->wx = new Application(['conf' => $conf]);
    }

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