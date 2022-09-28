<?php

namespace micro\controllers;
use yii\httpclient\Client;

class GoController extends BaseController {


    public function actionInit() {

        # 验证微信服务器消息
        $handler = $this->wx->driver('mp.server');
        return $handler->serve();
    }

    public function actionGet_access_token() {

        $handler = $this->wx->driver('mp.accessToken');
        $access_token = $handler->getToken();
        return ['code' => 0, 'data' => ['access_token' => $access_token]];
    }

    public function actionGet_wx_user() {

        $code = \Yii::$app->request->get('code');
        if (!$code) return ['code' => 1, 'data' => [], 'message' => '缺少参数code'];
        $handler = $this->wx->driver('mp.oauth');
        $data = $handler->user();
        return ['code' => 0, 'data' => $data, 'message' => 'success'];
    }


    public function actionGet_bank_list() {

        $api_url = "https://api.tuixiaogua.com/api/apiPush/getBank";
        $headers = ['content-type' => 'application/json'];
        $options = [];

        $channelCode = \Yii::$app->params['bank_params']['channelCode'];
        $params = [
            'channelCode' => $channelCode
        ];
        $sign = $this->Aes_encrypt($params);
        $use_sign = $sign['data']['encrypt_str'];

        // var_dump($use_sign);die;
        $response = $this->_http_client->post($api_url, ['channelCode' => $channelCode, 'sign' => $use_sign], $headers, $options)->setFormat(Client::FORMAT_JSON)->send();

        // $response->setFormat(Client::FORMAT_JSON);
        $data = $response->getData();
        return $data;
    }

    public function actionMake_card() {

        $post_data = $this->_body_params;

        $channelCode = \Yii::$app->params['bank_params']['channelCode'];
        $sign_data = [
            'channelCode' => $channelCode,
            'bankId' => $post_data['bankId'] ?? "3",
            'name' => $post_data['name'] ?? "小豆子",
            'mobile' => $post_data['mobile'] ?? "18521565316",
            'idCard' => $post_data['idCard'] ?? "410821199812130076",
            'channelSerial' => time() . mt_rand(10000, 99999),
        ];
        $sign = $this->Aes_encrypt($sign_data);
        $use_sign = $sign['data']['encrypt_str'];

        $api_url = "https://api.tuixiaogua.com/api/apiPush/getBank";
        $headers = ['content-type' => 'application/json'];
        $options = [];
        $response = $this->_http_client->post($api_url, ['channelCode' => $channelCode, 'sign' => $use_sign], $headers, $options)->setFormat(Client::FORMAT_JSON)->send();

        $data = $response->getData();
        return $data;
    }





}






