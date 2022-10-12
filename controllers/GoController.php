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

        $code = \Yii::$app->request->post('code');
        if (!$code) return ['code' => 1, 'data' => [], 'message' => '缺少参数code'];
        $handler = $this->wx->driver('mp.oauth');
        $data = $handler->user();
        return ['code' => 0, 'data' => $data, 'message' => 'success'];
    }


    public function actionGet_bank_list() {

        $cache_key = str_replace("/", "_", __METHOD__);
        $data = $this->_cache->get($cache_key);

        if (empty($data)) {
            $api_url = "https://api.tuixiaogua.com/api/apiPush/getBank";
            $headers = ['content-type' => 'application/json'];
            $options = [];

            $channelCode = \Yii::$app->params['bank_params']['channelCode'];
            $params = [
                'channelCode' => $channelCode,
                // 'bankName' => '平安银行',
            ];
            $sign = $this->Aes_encrypt($params);
            $use_sign = $sign['data']['encrypt_str'];

            // var_dump($use_sign);die;
            $response = $this->_http_client->post($api_url, ['channelCode' => $channelCode, 'sign' => $use_sign], $headers, $options)->setFormat(Client::FORMAT_JSON)->send();

            // $response->setFormat(Client::FORMAT_JSON);
            $data = $response->getData();

            // var_dump($data);die;
            // 处理数据
            $bank_icon = \Yii::$app->params['bank_icon'];
            if (isset($data['data']) && !empty($data['data'])) {
                foreach ($data['data'] as &$bank) {
                    // 判断银行 生成指定银行数据 
                    $bank['src'] = $bank_icon[$bank['bankId']]['icon_name'] ?? "bank_zgpa";
                    // $bank['src'] = "bank_zgpa";
                    $bank['mark'] = "易审批高额度";
                    $bank['award'] = "200+80";
                }
            }

            $this->_cache->set($cache_key, json_encode($data, JSON_UNESCAPED_UNICODE), 3600);

        } else {
            return json_decode($data, true);
        }


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

    public function actionGet_bank() {

        $post_data = $this->_body_params;
        $bank_id = $post_data['bank_id'] ?? "";
        if (!$bank_id) return ['code' => 1003, 'data' => [], 'message' => '缺少参数bank_id'];
        $bank_data = \Yii::$app->params['bank_icon'];

        return ['code' => 0, 'data' => $bank_data[$bank_id] ?? [], 'message' => 'success'];
    }





}






