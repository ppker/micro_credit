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

    public function actionAes_encrypt() {

        $data = [
            "bankId" => 1,
            "channelSerial" => "132784287788232",
            "idCard" => "410823199908042578",
            "name" => "张三",
            "mobile" => "13323853821"
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $aes_key = str_pad('wn4323f6bdp2', 16, 'z');
        // $data进行补位
        $full_data = $data;
        if (strlen($data) % 16) {
            $full_data = str_pad($full_data, strlen($data) + 16 - (strlen($data) % 16), "\0");
        }


        $encrypt_str = openssl_encrypt($full_data, 'AES-128-ECB', $aes_key, OPENSSL_RAW_DATA, '');
        $encrypt_str = base64_encode($encrypt_str);
        return ['code' => 0, 'data' => ['encrypt_str' => $encrypt_str], 'message' => 'success'];

    }
    
    
    public function actionMake_card() {

        $post_data = $this->_body_params;

        $sign_data = [
            'channelCode' => '5LQBXM',
            'bankId' => $post_data['bankId'] ?? "3",
            'name' => $post_data['name'] ?? "闫志鹏",
            'mobile' => $post_data['mobile'] ?? "18521568316",
            'idCard' => $post_data['idCard'] ?? "410821199012130076",
            'channelSerial' => time() . mt_rand(10000, 99999),
        ];
        $sign = $this->Aes_encrypt($sign_data);
        $use_sign = $sign['data']['encrypt_str'];

        $api_url = "https://api.tuixiaogua.com/api/apiPush/getPage";
        $headers = ['content-type' => 'application/json'];
        $options = [];
        $response = $this->_http_client->post($api_url, ['channelCode' => '5LQBXM', 'sign' => $use_sign], $headers, $options)->setFormat(Client::FORMAT_JSON)->send();

        $data = $response->getData();
        return $data;
    }





}






