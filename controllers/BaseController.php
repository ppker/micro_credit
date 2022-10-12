<?php

namespace micro\controllers;
use yii\rest\ActiveController;
use abei2017\wx\Application;
use yii\httpclient\Client;
use yii\web\HttpException;

class BaseController extends ActiveController {

    public $modelClass = 'micro\models\Post';
    
    public $wx = null;

    protected $_request = null;
    protected $_body_params = null;
    protected $_http_client = null;
    protected $_cache = null;

    public function init() {

        parent::init();
        $conf = \Yii::$app->params['wx']['mp'];
        $this->wx = new Application(['conf' => $conf]);
        $this->_request = \Yii::$app->getRequest();
        $this->_body_params = \Yii::$app->getRequest()->getBodyParams();
        $this->_http_client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
        $this->_cache = \Yii::$app->cache;
    }

    public function behaviors() {

        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions() {

        return [];
    }

    public function verbs() {

        return [];
    }

    
    public function Aes_encrypt($data = []) {

        if (empty($data)) throw new HttpException('参数为空', 1001);

        $aeskey = \Yii::$app->params['bank_params']['aes_key'];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $aes_key = str_pad($aeskey, 16, 'z');
        // $data进行补位
        $full_data = $data;
        if (strlen($data) % 16) {
            $full_data = str_pad($full_data, strlen($data) + 16 - (strlen($data) % 16), "\0");
        }
        $encrypt_str = openssl_encrypt($full_data, 'AES-128-ECB', $aes_key, OPENSSL_RAW_DATA, '');
        $encrypt_str = base64_encode($encrypt_str);
        if ($encrypt_str) {
            // $encrypt_str = rtrim($encrypt_str);
            return ['code' => 0, 'data' => ['encrypt_str' => $encrypt_str], 'message' => 'success'];
        }
        return ['code' => 1002, 'data' => ['encrypt_str' => ""], 'message' => 'encrypt fail'];

    }

    public function Aes_decrypt($input_str) {

        if (empty($data)) throw new HttpException('参数为空', 1001);

        $aeskey = \Yii::$app->params['bank_params']['aes_key'];
        $aes_key = str_pad($aeskey, 16, 'z');
        
        $input_str = base64_decode($input_str);

        if (strlen($input_str) % 16) {
            $full_input_str = str_pad($input_str, strlen($input_str) + 16 - (strlen($input_str) % 16), "\0");
        } else $full_input_str = $input_str;


        $native_str = openssl_decrypt($full_input_str, 'AES-128-ECB', $aes_key, OPENSSL_RAW_DATA, '');
        $native_str = rtrim($native_str);
        $native_str = json_decode($native_str, true);
        return ['code' => 0, 'data' => ['native_str' => $native_str], 'message' => 'success'];


    }

    public function makeInviteCode($num) {

        $invite_code = "";
        for ($i = 1; $i <= $num; $i++) {
            $letter = chr(mt_rand(65, 90));
            if (mt_rand(0, 99) >= 50) {
                $letter = strtolower($letter);
            }
            $invite_code .= $letter;
        }
        return $invite_code;
    }


}