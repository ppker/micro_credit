<?php

namespace micro\models;
use yii\httpclient\Client;

class YhsPay extends \yii\base\BaseObject {

    protected $_db = null;
    protected $_http_client = null;

    const PAY_TYPE = [
        '1' => '核卡',
        '2' => '激活',
        '3' => '首刷',
        '4' => '直推',
        '5' => '间接推',
        '6' => '提现',
        '7' => '退款',
    ];

    protected $_publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApQyOIOBcA8Y8IlBQFKFGEwzUigCoF5n9hwTTAk6dywFYCHjd7XJn8FCL6AWtKvP6oWBiWXmeER8Z2uD0CN7YqKNKXLJRXA0YfcummtrCHOOt4nrPOn3QtUZm0HEY28vc765wgU3S2tm65Q5PhLTbrZtZ1qQeC2g/E355EYG0EYKaLy4R7Jd8wGt9VSkT/p0GBf52+B/leecx12QO0ZQCNQNbc2HmHUWAFZajHJPGgVyMOez98ybIrcW9h1MTpPUuo37QEBRM8nNRGut6ZTPCfkNyg+zq5pZ8vgrGFCzdFzvRqZOfbgVU2KQPUVLDlN81S3a6NOlCrjTNMMcVZsta/QIDAQAB';

    protected $_MAX_ENCRYPT_BLOCK = 245;
    protected $_MAX_DECRYPT_BLOCK = 256;


    protected $_pay_url = "http://yhs-gateway.juheba.top:8888/open/api"; // 测试提现接口
    protected $_enterpriseNo = "8880010000336";
    protected $_channelNo = "8880755000115";
    protected $_version = "V2.0.0";
    protected $_taskNo = "T1509809989825286144";




    public function init() {

        parent::init();
        $this->_db = \Yii::$app->getDb();
        $this->_http_client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
    }


    public function getEncrypt($data) {

        if (empty($data)) return ['code' => 1003, 'data' => [], 'message' => "参数异常"];

        $public_key = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($this->_publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        $encrypted = "";
        $str = json_encode($data);
        $output = '';

        while ($str) {
            $input = substr($str, 0, $this->_MAX_ENCRYPT_BLOCK);
            $str = substr($str, $this->_MAX_ENCRYPT_BLOCK);
            openssl_public_encrypt($input, $encrypted, $public_key);
            $output .= $encrypted;
        }

        $output = base64_encode($output);
        return $output;
    }


    public function signCheck($data, $sign) {

        $content_data = json_encode($data);
        $public_key = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($this->_publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        return openssl_verify($content_data, base64_decode($sign), $public_key);
    }



    public function msectime() {

        list($msec, $sec) = explode(' ', microtime());
        $str_time = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $str_time;
    }

    public function get_orderno() {

        $time_str = str_replace(".", "", microtime(true));
        $time_str = str_pad($time_str, 16, '0');
        $channelSerial = $time_str . (string)mt_rand(10000, 99999);
        return $channelSerial;
    }


    protected function pay_for($user_data) {

        $params = [];
        $params['enterpriseNo'] = $this->_enterpriseNo;
        $params['channelNo'] = $this->_channelNo;
        $params['apiCode'] = 1000;
        $params['version'] = $this->_version;

        $entOrderNo = $this->get_orderno();
        $body = [
            'timestamp' => $this->msectime(),
            'taskNo' => $this->_taskNo,
            'entOrderNo' => $entOrderNo,
            'payeeName' => (string)$user_data['name'],
            'payeeIdCard' => (string)$user_data['idcard'],
            'payeePhone' => (string)$user_data['mobile'],
            'payeeAccount' => (string)$user_data['card_num'],
            'paymentModel' => '100',
            'amount' => (int)$user_data['tx_money'] * 100,
        ];

        $params['body'] = $this->getEncrypt($body);

        $headers = ['content-type' => 'application/json'];
        $options = [];
        $response = $this->_http_client->post($this->_pay_url, $params, $headers, $options)->setFormat(Client::FORMAT_JSON)->send();
        $data = $response->getData();
        if (!$data) $data = [];
        $data['entOrderNo'] = $entOrderNo;
        return $data;

        // return ['code' => 0, 'data' => $data, 'message' => "success"];
    }


    public function test() {

        $url = "https://api.rrtuika.com/apiv1/pay_result";
        $headers = ['content-type' => 'application/json'];
        $options = [];

        $response = $this->_http_client->post($url, ['a' => 'a1', 'b' => 'b1'], $headers, $options)->setFormat(Client::FORMAT_JSON)->send();
        $data = $response->getData();

        return ['code' => 0, 'data' => $data, 'message' => "success"];

    }

    public function doWithdraw($data) {

        // userid, tx_money card_bag_id
        // 申请提现
        $user_info = $this->_db->createCommand("select * from user where id = :userid and openid = :openid and status = 0")->bindValues([
            ':userid' => (int)$data['userid'],
            ':openid' => (string)$data['openid']
        ])->queryOne();
        
        $tx_bank_card_info = $this->_db->createCommand("select * from bank_bag where id = :id and openid=:openid and status = 0")->bindValues([
            ':id' => (int)$data['card_bag_id'],
            ':openid' => (string)$data['openid']
        ])->queryOne();

        if (empty($user_info) || empty($tx_bank_card_info)) {
            return ['code' => 1010, 'data' => [], 'message' => "用户数据存在异常，请联系客服处理"];
        }

        $use_data = [
            'name' => (string)$tx_bank_card_info['name'],
            'idcard' => (string)$user_info['idcard'],
            'mobile' => (string)$tx_bank_card_info['mobile'],
            'card_num' => (string)$tx_bank_card_info['card_num'],
            'tx_money' => (int)$data['tx_money']
        ];


        // 提现之前查询用户可提现余额 加行锁 防止并发冲突 (后期放到消息中间件MQ中去处理提款业务)
        // 
        $user_can_withdrawal = $this->get_user_withdrawal($data);
        if (is_array($user_can_withdrawal) && $user_can_withdrawal['code'] != 0) {
            return $user_can_withdrawal;
        }

        if ($user_can_withdrawal < (int)$data['tx_money']) {
            return ['code' => 100554, 'data' => [], 'msg' => "您申请提现的金额大于可提现的余额"];
        }


        $res_data = $this->pay_for($use_data);

        // 创建自己的流水记录
        if ('000000' == $res_data['code']) {
            $re1 = $this->_db->createCommand()->insert('user_earning', [
                'user_id' => (int)$data['userid'],
                'openid' => (string)$data['openid'],
                'channelSerial' => (string)$res_data['entOrderNo'],
                'settle_type' => '提现',
                'money_one' => (int)$data['tx_money'],
                'pay_type' => 6, // 提现
            ])->execute();
        }
        
        return $res_data;

    }


    public function get_user_withdrawal($data) {

        if (in_array('', $data)) {
            return ['code' => 1004, 'data' => [], 'msg' => "参数异常, 请联系客服处理"];
        }


        $total_money = $this->_db->createCommand("select sum(money_one) as total_money from user_earning where user_id = :user_id and pay_type not in (6, 7)")->bindValues([':user_id' => $data['userid']])->queryScalar();
        // 提现金额
        $total_out_money = $this->_db->createCommand("select sum(money_one) as total_money from user_earning where user_id = :user_id and pay_type = 6")->bindValues([':user_id' => $data['userid']])->queryScalar();

        // 提现失败 系统退款金额
        $total_refund_money = $this->_db->createCommand("select sum(money_one) as total_money from user_earning where user_id = :user_id and pay_type = 7")->bindValues([':user_id' => $data['userid']])->queryScalar();

        $real_total_out_money = sprintf("%.2f", $total_out_money - $total_refund_money);

        $user_withdraw_money = sprintf("%.2f", (float)($total_money - $real_total_out_money));
        return $user_withdraw_money;
    }





    public function refund($data) {

        // 从提现里面找数据 然后 新增插入 退款流水记录
        $channelSerial = $data['entOrderNo'] ?? "";
        $tx_info = $this->_db->createCommand("select * from user_earning where channelSerial = :channelSerial and pay_type = 6")->bindValues([
            ':channelSerial' => $channelSerial
        ])->queryOne();

        if (empty($tx_info)) {
            return ['code' => 1004, 'data' => [], 'message' => "没有申请提现流水记录"];
        }

        $re1 = $this->_db->createCommand()->insert('user_earning', [
            'user_id' => (int)$tx_info['user_id'],
            'openid' => (string)$tx_info['openid'],
            'channelSerial' => (string)$channelSerial,
            'settle_type' => '退款',
            'money_one' => (int)$tx_info['money_one'],
            'pay_type' => 7, // 提现
        ])->execute();

        if ($re1) return ['code' => 0, 'data' => [], 'message' => "成功"];
        return ['code' => 1005, 'data' => [], 'message' => "退款失败"];

    }




}