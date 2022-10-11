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

    public function actionUser() {

        $use_data = $this->_body_params;

        if (in_array("", $use_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }

        $db = \Yii::$app->getDb();

        $re = $db->createCommand('select id from user where openid = :openid and status = :status')->bindValues([':openid' => $use_data['openid'], ':status' => 0])
        ->queryAll();
        if ($re) {
            return ['code' => 1005, 'data' => [], 'message' => "您已经注册过了"];
        } else {

            $re2 = $db->createCommand('select id from user where invite_code = :invite_code and status = :status')->bindValues([':invite_code' => $use_data['top_invite_code'], ':status' => 0])->queryOne();

            if (empty($re2)) {
                return ['code' => 1006, 'data' => [], 'message' => "邀请码无效"];
            } else {
                $re = $db->createCommand()->insert('user', [
                    'openid' => (string)$use_data['openid'],
                    'nickname' => (string)$use_data['nickname'],
                    'headimgurl' => (string)$use_data['headimgurl'],
                    'top_invite_code' => (string)$use_data['top_invite_code'],
                    'invite_code' => $this->makeInviteCode(8),
                    'top_userid' => (int)$re2['id'],
                    'phone' => (string)$use_data['mobile'],
                    'real_name' => (string)$use_data['real_name'],
                    'idcard' => (string)$use_data['idcard']
                ])->execute();
                if ($re) return ['code' => 0, 'data' => [], 'message' => "success"];
                return ['code' => 1003, 'data' => [], 'message' => "fail, 操作数据失败"];
            }

        }
    }


    public function actionGet_user() {

        $openid = $this->_body_params['openid'];
        if (empty($openid)) return ['code' => 1004, 'data' => [], 'message' => "参数异常"];

        $db = \Yii::$app->getDb();
        $re = $db->createCommand('select id, openid, nickname, headimgurl, invite_code, top_userid, phone, real_name, idcard from user where openid = :openid and status = :status order by id desc')->bindValues([':openid' => $openid, ':status' => 0])->queryOne();

        return ['code' => 0, 'data' => $re, 'message' => "success"];

    }



}