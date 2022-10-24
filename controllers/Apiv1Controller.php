<?php

namespace micro\controllers;
use yii\httpclient\Client;
use Overtrue\Pinyin\Pinyin;
use micro\models\CreditData;
use micro\models\YhsPay;

class Apiv1Controller extends BaseController {


    public function actionCards() {

        $use_data = $this->_body_params;
        if (empty($use_data)) {
            return ['code' => 1002, 'data' => [], 'message' => "请post参数"];
        }

        // 获取用户信息
        $user_data = [];
        if (isset($use_data['idCard']) && $use_data['idCard']) {
            $user_data = (new CreditData())->getUserInfoByIdCard($use_data['idCard']);
            if (empty($user_data)) $user_data = [];
        }


        $db = \Yii::$app->getDb();

        $show_bank_list = \Yii::$app->params['show_bank_list'];
        $api_server_bankid = \Yii::$app->params['api_server_bankid'];

        // 根据渠道商 bank_id 回溯自己的bank配置数据
        // 查询订单的基底数据
        $order_base_data = $db->createCommand("select * from credit_card where channelSerial = :channelSerial and mark = '0' order by id asc")->bindValues([
            ':channelSerial' => (string)$use_data['channelSerial']
        ])->queryOne();
        $frontend_bank_id = $order_base_data['frontend_bank_id'] ?? "";
        if (empty($frontend_bank_id)) return ['code' => 1004, 'data' => [], 'message' => "订单数据不存在"];

        $api_bank_id_key = $frontend_bank_id;
        $settle_type = $show_bank_list[$api_bank_id_key - 1]['settle_type'];
        $order_bank_info = $show_bank_list[$api_bank_id_key - 1] ?? [];

        $do_date = date('Y-m-d', strtotime($order_base_data['create_at']));
        $do_date_30 = date('Y-m-d', strtotime("$do_date +30 days"));
        $today = date('Y-m-d');

        $pass = false;
        if ($today >= $do_date_30) { // 过期了
            $pass = true;
        }


        if (!$pass) {
            // 计算订单结算的金额
            $pay_type = 0; // 1=>核卡, 2=>激活, 3=>首刷

            // var_dump($settle_type);die;
            $pay_money = 0;
            if (trim($use_data['applicationStatus']) == 'P') { // 核卡通过
                if ($settle_type == "核卡" || $settle_type == "新户核卡+首刷") { // 核卡和新户核卡+首刷才给钱
                    $pay_money = $order_bank_info['money_one'];
                    $pay_type = 1;
                }
            }
            if (trim($use_data['activated']) == 'P') { // 激活
                if ($settle_type == "激活") {
                    $pay_money = $order_bank_info['money_one'];
                    $pay_type = 2;
                }
            }
            if (trim($use_data['firstUsed']) == 'P') { // 首刷
                if ($settle_type == "首刷") {
                    $pay_type = 3;
                    // 截止天数
                    $later_date = $order_bank_info['over_sk_days'];
                    // 截止日期
                    $later_date_string = date('Y-m-d', strtotime("$do_date " . "+{$later_date} day"));

                    if ($today < $later_date_string) { // 最短期限之内的首刷
                        $pay_money = $order_bank_info['money_one'];
                    } else {
                        $pay_money = $order_bank_info['money_late'];
                    }

                    
                } elseif ($settle_type == "新户核卡+首刷") {
                    $pay_type = 3;
                    // 截止天数
                    $later_date = $order_bank_info['over_sk_days'];
                    // 截止日期
                    $later_date_string = date('Y-m-d', strtotime("$do_date " . "+{$later_date} day"));

                    if ($today < $later_date_string) { // 最短期限之内的首刷
                        $pay_money = $order_bank_info['money_two'];
                    } else {
                        $pay_money = $order_bank_info['money_late'];
                    }
                }
            }
        }

        // 走事务
        $transaction = $db->beginTransaction();
        try {
            $re = $db->createCommand()->insert('credit_card', [
                'openid' => $user_data['openid'] ?? "",
                'unionid' => '',
                'userid' => $user_data['id'] ?? "0",
                'bankId' => (int)$use_data['bankId'],
                'name' => $use_data['name'] ?? "",
                'mobile' => $use_data['mobile'] ?? "",
                'idCard' => $use_data['idCard'] ?? "",
                'channelSerial' => (string)$use_data['channelSerial'],
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


            // 30天之后不予结算
            if (!$pass && $pay_money > 0) {
                // 结算金额
                // 幂等性
                $re0 = $db->createCommand("select id, update_at from user_earning where channelSerial = :channelSerial and user_id = :user_id and pay_type = :pay_type")->bindValues([
                    ':channelSerial' => (string)$use_data['channelSerial'],
                    ':user_id' => $user_data['id'] ?? "0",
                    ':pay_type' => $pay_type,
                ])->queryOne();

                if (!$re0) {
                    $re1 = $db->createCommand()->insert('user_earning', [
                        'user_id' => $user_data['id'] ?? "0",
                        'openid' => $user_data['openid'] ?? "",
                        'channelSerial' => (string)$use_data['channelSerial'],
                        'settle_type' => (string)$settle_type,
                        'money_one' => $pay_money,
                        'pay_type' => $pay_type,
                    ])->execute();
                }

                
            }
            
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

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

        if (empty($re)) return ['code' => 0, 'data' => $re, 'message' => "success"];
        if ($re['real_name']) {
            $pinyin_name = (new Pinyin())->name($re['real_name']);
            $pinyin_name = array_map(function($word) {
                return ucfirst($word);
            }, $pinyin_name);
            $re['real_name_pinyin'] = implode("", $pinyin_name);
        } else $re['real_name_pinyin'] = "";

        return ['code' => 0, 'data' => $re, 'message' => "success"];

    }

    public function actionGet_user_id() {

        $id = $this->_body_params['userid'];
        $user_data = (new CreditData())->getUserInfoById($id);
        return ['code' => 0, 'data' => $user_data ?: [], 'message' => "success"];
    }


    public function actionPay_result() {

        $data = $this->_body_params;

        if (empty($data)) return ['handled' => 'SUCCESS'];

        // 数据安全校验
        $re_num = (new YhsPay())->signCheck($data['body'], $data['sign']);
        
        if (1 == $re_num) {
            if (!in_array($data['body']['status'], [100, 200, 400])) { // 付款失败, 进行退款 
                $re1 = (new YhsPay())->refund($data['body']); // entOrderNo
            }
        }

        // 记录日志
        \Yii::info($data, 'api');
        $c = \Yii::$app->log;

        return ['handled' => 'SUCCESS'];
    }




}