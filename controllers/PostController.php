<?php

namespace micro\controllers;

class PostController extends BaseController
{
    public $modelClass = 'micro\models\Post';


    public function actionHi() {

        return ['code' => 0, 'message' => 'ok'];
    }
}