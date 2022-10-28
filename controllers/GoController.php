<?php

namespace micro\controllers;
use yii\httpclient\Client;
use micro\models\CreditData;
use micro\models\YhsPay;
use Overtrue\Pinyin\Pinyin;

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

        // $data = [];

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

    public function actionGet_new_bank_list() {

        $bank_new_list_data = \Yii::$app->params['show_bank_list'];
        return ['code' => 0, 'data' => $bank_new_list_data ?: [], 'message' => 'success'];
    }

    public function actionGet_new_bank_list2() {

        $bank_new_list_data = \Yii::$app->params['show_bank_list'];
        $api_server_bankid = \Yii::$app->params['api_server_bankid'];

        foreach ($bank_new_list_data as &$val) {
            $val['real_bank_id'] = $api_server_bankid[$val['api_bank_id']] ?? 0;
        }

        return ['code' => 0, 'data' => $bank_new_list_data ?: [], 'message' => 'success'];
    }




    public function actionMake_card() {

        $post_data = $this->_body_params;
        
        $time_str = str_replace(".", "", microtime(true));
        $time_str = str_pad($time_str, 16, '0');
        $channelSerial = $time_str . (string)mt_rand(10000, 99999);
        // 自己提交一份打底
        (new CreditData())->addCardOrder($post_data, $channelSerial);

        $channelCode = \Yii::$app->params['bank_params']['channelCode'];
        $sign_data = [
            'channelCode' => (string)$channelCode,
            'bankId' => $post_data['bankId'] ?? "",
            'name' => $post_data['name'] ?? "",
            'mobile' => $post_data['mobile'] ?? "",
            'idCard' => $post_data['idCard'] ?? "",
            'channelSerial' => (string)$channelSerial
        ];
        $sign = $this->Aes_encrypt($sign_data);
        $use_sign = $sign['data']['encrypt_str'];

        $api_url = "https://api.tuixiaogua.com/api/apiPush/getPage";

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
        $bank_data = \Yii::$app->params['show_bank_list'];

        $need_data = [];
        if (!empty($bank_data)) {
            foreach($bank_data as $val) {
                if ($val['api_bank_id'] == $bank_id) {
                    $need_data = $val;
                    // 替换真正的bank_id
                    $need_data['real_bank_id'] = \Yii::$app->params['api_server_bankid'][$bank_id] ?? 0;
                }
            }
        }

        return ['code' => 0, 'data' => $need_data, 'message' => 'success'];
    }

    public function actionAdd_bank_card() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }

        return (new CreditData())->addBankCard($post_data);

    }

    public function actionGet_bank_card() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }
        return (new CreditData())->getBankCard($post_data);
    }

    public function actionGet_bank_order() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }
        return (new CreditData())->getBankOrder($post_data);
    }

    public function actionGet_team() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }
        return (new CreditData())->getMyTeam($post_data);
    }


    public function actionGet_wallet() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }
        return (new CreditData())->getWalletData($post_data);
    }

    public function actionGet_bank_bag() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }
        return (new CreditData())->getBankBag($post_data);
    }


    public function actionWithdraw() {

        $post_data = $this->_body_params;
        if (in_array("", $post_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常"];
        }
        return (new YhsPay())->doWithdraw($post_data);
    }


    public function actionSend_sms() {

        
        $post_data = $this->_body_params;
        if (in_array("", $post_data) || !isset($post_data['openid']) || !isset($post_data['mobile'])) {
            return ['code' => 1004, 'data' => [], 'message' => "您提交的参数异常"];
        }
        // 判断时间合法
        $get_sms_code = $this->_cache->get('sms_' . $post_data['openid']);
        if ($get_sms_code) {
            return ['code' => 1008, 'data' => [], 'message' => '请等待到短信验证码冷却时间结束'];
        }
        // 判断次数合法
        $sms_times_key = 'sms_times_' . $post_data['openid'] . '_' . date('Ymd');
        $sms_times = (int)$this->_cache->get($sms_times_key);
        if ($sms_times >= 25) {
            return ['code' => 1009, 'data' => [], 'message' => '您已经超过了每日短信验证码次数'];
        }

        // 缓存3分钟生成验证码
        $sms_code = mt_rand(11112, 99998);
        $this->_cache->set('sms_' . $post_data['openid'], $sms_code, 180);

        
        // 发送验证码
        $msm_data = \Yii::$app->params['sms'];

        $url = $msm_data['sms_url'];
        $account = $msm_data['account'] ?? "";
        $pswd = $msm_data['pswd'] ?? "";

        $ts = date('YmdHis');
        $post_data = [
            'account' => $account,
            'ts' => $ts,
            'pswd' => md5($account . $pswd . $ts),
            'msg' => '【人人推卡】您的验证码为{$var}，3分钟内有效，如非本人操作，请忽略此条短信。',
            'params' => $post_data['mobile'] . "," . $sms_code,
            'needstatus' => "true",
            'product' => '',
            'extno' => '',
            'resptype' => 'json',
        ];

        $headers = ['content-type' => 'application/x-www-form-urlencoded'];
        $options = [];

        // die('ssss');
        
        
        // $response = $this->_http_client->post($url, $post_data, $headers, $options)->setFormat(Client::FORMAT_URLENCODED)->send();

        // $data = $response->getData();

        // 验证码次数加1
        $sms_times++;
        $this->_cache->set($sms_times_key, $sms_times, 86400);

        return ['code' => 0, 'data' => [], 'message' => 'success'];
        return $data;

    }


    public function actionGet_name_pinyin() {

        $post_data = $this->_body_params;
        if (empty($post_data['name'])) return ['code' => 0, 'data' => ['name' => ''], 'message' => 'success'];

        $pinyin_name = (new Pinyin())->name($post_data['name']);
        $pinyin_name = array_map(function($word) {
            return ucfirst($word);
        }, $pinyin_name);
        $real_name_pinyin = implode("", $pinyin_name);

        return ['code' => 0, 'data' => ['name' => $real_name_pinyin], 'message' => 'success'];
    }





    public function actionPay_to() {

        // $result = (new YhsPay())->pay_for();
        // $result = (new YhsPay())->test();
        
        /*$data = [
            'entOrderNo' => "166643484447130062821",
            'pfOrderNo' => '1583768654250881024',
            'applyTime' => '2022-10-22 18:34:06'
        ];

        $sign = "cNAk8OF4P02ytXKO4HVe9zuc72TDw/eQk1BY2RZ+FJkWqi1RWf3ZZIEQnLRdoCts3kVpm0tfWbY9mLGw9DNSu07a8EoFiFy8MsFztyLqswmwoMW+sxfCsAY2ERnL2QUK7UBXUaiVAD+Ouo78mww9A9fhbenQwEwJ0G3LOb8hPsxupmIGaAgeZqNWpAXsEbomR0w/ufLLs/SC4a++k0gh8h4/c8dNTsWRCfJRs0E79vmhezJUTDAgZet9JPaABo6laREOgiQtLB4IKXCiulLDdWwLMO+yhPS/GOwL7caN64U53zMIV/apbkJV68nMM4Xfg8OpayOrUYA/YS3Dr/vwBQ==";
        $re = (new YhsPay())->signCheck($data, $sign);
        var_dump($re);die;*/

        $data = [
            'paymentModel' => '100',
            'amount' => '100',
            'finishTime' => '2022-10-22 19:13:15',
            'fee' => '0',
            'entOrderNo' => '166643686982890081380',
            'refOrderNo' => '1583777141039149056',
            'applyTime' => '2022-10-22 19:07:50',
            'status' => '300',
        ];

        $sign = 'Jh7QFdLtmpFqGYET00GC0y+z4h5UE3gUD04fq8wl/v/cS7PIUVoLT/6LLSdkgWjZIN/WUXpILk0YBWOmJ00BaZpm02sph2SDZhk7cTuM0wmYXfq6ViYO6pfYodZq9CP/MWVvtXgfMtEFCnAOq2faYhi9JuiLN6mrxKBz4/x5hkLkntuTb+RbJzD3hsKARr1Fcdn17nlRlKPSCbwAybd0PDk0dNy1za4LyDfD5VloiICnsBlf3SuQl3pMdeAkb7CARPlTvu2phNwY90OoF52Eo4b0dzj4uhuqaHLrnvqeFULS22tanios8YsZx/hYMy6LFeuyn9pxiMzmYrBARxM3rw==';
        $re = (new YhsPay())->signCheck($data, $sign);
        var_dump($re);die;

        return $result;
    }



}