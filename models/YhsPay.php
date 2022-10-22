<?php

namespace micro\models;
use yii\httpclient\Client;

class YhsPay extends \yii\base\BaseObject {

    protected $_db = null;
    protected $_http_client = null;

    protected $_publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApQyOIOBcA8Y8IlBQFKFGEwzUigCoF5n9hwTTAk6dywFYCHjd7XJn8FCL6AWtKvP6oWBiWXmeER8Z2uD0CN7YqKNKXLJRXA0YfcummtrCHOOt4nrPOn3QtUZm0HEY28vc765wgU3S2tm65Q5PhLTbrZtZ1qQeC2g/E355EYG0EYKaLy4R7Jd8wGt9VSkT/p0GBf52+B/leecx12QO0ZQCNQNbc2HmHUWAFZajHJPGgVyMOez98ybIrcW9h1MTpPUuo37QEBRM8nNRGut6ZTPCfkNyg+zq5pZ8vgrGFCzdFzvRqZOfbgVU2KQPUVLDlN81S3a6NOlCrjTNMMcVZsta/QIDAQAB';

    protected $_MAX_ENCRYPT_BLOCK = 245;
    protected $_MAX_DECRYPT_BLOCK = 256;




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


    public function pay_for() {

        $url = "http://yhs-gateway.juheba.top:8888/open/api";

        $params = [];
        $params['enterpriseNo'] = $this->_enterpriseNo;
        $params['channelNo'] = $this->_channelNo;
        $params['apiCode'] = 1000;
        $params['version'] = $this->_version;

        $body = [
            'timestamp' => $this->msectime(),
            'taskNo' => 'T1509809989825286144',
            'entOrderNo' => $this->get_orderno(),
            'payeeName' => '闫志鹏',
            'payeeIdCard' => '410821199012130076',
            'payeePhone' => '18521568316',
            'payeeAccount' => '6214851213319739',
            'paymentModel' => '100',
            'amount' => '100',
        ];

        $params['body'] = $this->getEncrypt($body);

        $headers = ['content-type' => 'application/json'];
        $options = [];
        $response = $this->_http_client->post($url, $params, $headers, $options)->setFormat(Client::FORMAT_JSON)->send();
        $data = $response->getData();

        return ['code' => 0, 'data' => $data, 'message' => "success"];

    }





}