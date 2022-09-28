<?php

namespace micro\controllers;
use yii\httpclient\Client;

class Apiv1Controller extends BaseController {


    public function actionCards() {

        $use_data = $this->_body_params;
        if (empty($use_data)) {
            return ['code' => 1002, 'data' => [], 'message' => "请post参数"];
        }

        $db = \Yii::$app->getDb();
        $re = $db->createCommand()->insert('credit_card', [
            'openid' => '',
            'unionid' => '',
            'bankId' => (int)$use_data['bankId'],
            'name' => $use_data['name'] ?? "",
            'mobile' => $use_data['mobile'] ?? "",
            'idCard' => $use_data['idCard'] ?? "",
            'channelSerial' => (int)$use_data['channelSerial'],
            'applyCompleted' => $use_data['applyCompleted'] ?? "",
            'applyCompletedData' => $use_data['applyCompletedData'] ?? "",
            'applicationStatus' => $use_data['applicationStatus'] ?? "",
            'applicationStatusDate' => $use_data['applicationStatusDate'] ?? "",
            'isNewUser' => (int)$use_data['isNewUser'],
            'activated' => $use_data['activated'] ?? "",
            'activationDate' => $use_data['activationDate'] ?? "",
            'firstUsed' => $use_data['firstUsed'] ?? "",
            'firstUsedDate' => $use_data['firstUsedDate'] ?? "",
        ])->execute();

        if ($re) return ['code' => 0, 'data' => [], 'message' => "success"];
        return ['code' => 1003, 'data' => [], 'message' => "fail, 操作数据失败"];
    }
}