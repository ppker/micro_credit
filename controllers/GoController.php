<?php

namespace micro\controllers;
use abei2017\wx\Application;

class GoController extends BaseController {


    public function actionInit() {

        # 验证微信服务器消息
        $conf = \Yii::$app->params['wx']['mp'];
        $app = new Application(['conf' => $conf]);
        $handler = $app->driver('mp.server');
        return $handler->serve();
    }

}