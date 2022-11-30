<?php

namespace micro\controllers;
use yii\httpclient\Client;
use Overtrue\Pinyin\Pinyin;
use micro\models\CreditData;
use micro\models\YhsPay;

class Apiv1Controller extends BaseController {


    public function actionCards() {

        $use_data = $this->_body_params;

        // 记录日志
        \Yii::info($use_data, 'api');
        $c = \Yii::$app->log;

        if (empty($use_data)) {
            return ['code' => 1002, 'data' => [], 'message' => "请post参数"];
        }

        // 查询订单的基底数据
        $db = \Yii::$app->getDb();
        $order_base_data = $db->createCommand("select * from credit_card where channelSerial = :channelSerial and mark = '0' order by id asc")->bindValues([
            ':channelSerial' => (string)$use_data['channelSerial']
        ])->queryOne();
        $frontend_bank_id = $order_base_data['frontend_bank_id'] ?? "";
        if (empty($frontend_bank_id) || empty($order_base_data)) return ['code' => 1004, 'data' => [], 'message' => "订单数据不存在"];


        // 获取用户信息 通过 channelSerial 查询底部数据
        $user_data = [
            'id' => (int)$order_base_data['userid'],
            'openid' => (string)$order_base_data['openid']
        ];


        /*if (isset($use_data['idCard']) && $use_data['idCard']) {
            $user_data = (new CreditData())->getUserInfoByIdCard($use_data['idCard']);
            if (empty($user_data)) $user_data = [];
        }*/

        $show_bank_list = \Yii::$app->params['show_bank_list'];
        $api_server_bankid = \Yii::$app->params['api_server_bankid'];

        // 根据渠道商 bank_id 回溯自己的bank配置数据
        

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
                if ($settle_type == "核卡" || $settle_type == "新户核卡+首刷" || $settle_type == "新户核卡+激活") { // 核卡和新户核卡+首刷才给钱
                    $pay_money = $order_bank_info['money_one'];
                    $pay_type = 1;
                }
            }
            if (trim($use_data['activated']) == 'P') { // 激活
                if ($settle_type == "激活") {
                    $pay_money = $order_bank_info['money_one'];
                    $pay_type = 2;
                } elseif ($settle_type == "新户核卡+激活") {
                    $pay_money = $order_bank_info['money_two'];
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

                    // 触发给导师A 2%，B 4% 佣金提成分红
                    $user_b = $db->createCommand("select top_userid, real_name from user where id = :id")
                    ->bindValues([':id' => (int)$user_data['id']])->queryOne();
                    $user_b_id = $user_b['top_userid'] ?? "";
                    if ($user_b_id) {
                        $user_a = $db->createCommand("select top_userid, openid from user where id = :id")->bindValues([':id' => (int)$user_b_id])->queryOne();
                        $user_a_id = $user_a['top_userid'] ?? "";

                        $user_a_info = $db->createCommand("select openid from user where id = :id")->bindValues([':id' => $user_a_id])->queryOne();


                        $insert_data = [
                            [$user_b_id, $user_a['openid'] ?? "", (string)$use_data['channelSerial'], '团队-' . $user_b['real_name'] . '佣金分成', round($pay_money * 0.04, 2), 4]
                        ];

                        if ($user_a && $user_a_id) {
                            array_push($insert_data, [
                                $user_a_id, $user_a_info['openid'] ?? "", (string)$use_data['channelSerial'], '团队-' . $user_b['real_name'] . '佣金分成',
                                round($pay_money * 0.02, 2), 5
                            ]);
                        }


                        $re2 = $db->createCommand()->batchInsert('user_earning', ['user_id', 'openid', 'channelSerial', 'settle_type', 'money_one', 'pay_type'], $insert_data)->execute();
                    }
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

        /*if (in_array("", $use_data)) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常,请重新提交"];
        }*/

        if (!isset($use_data['mobile']) || !isset($use_data['idcard'])) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常,请重新提交"];
        }

        if (!preg_match('/(^((\+86)|(86))?(1[3-9])\d{9}$)|(^(0\d{2,3})-?(\d{7,8})$)/', $use_data['mobile'])) {
            return ['code' => 1004, 'data' => [], 'message' => "请提交正确的手机号"];
        }

        if (!preg_match('/^[1-9]\d{5}(19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i', $use_data['idcard'])) {
            return ['code' => 1004, 'data' => [], 'message' => "请提交正确的身份证号"];
        }

        if (in_array("", [$use_data['openid'], $use_data['msgcode']])) {
            return ['code' => 1004, 'data' => [], 'message' => "参数异常,请重新提交"];
        }

        // 验证短信验证码
        $sms_res = (new CreditData())->checkSmsCode(['openid' => $use_data['openid'], 'sms_code' => $use_data['msgcode']]);

        if (0 != $sms_res['code']) return $sms_res;

        $db = \Yii::$app->getDb();

        $re = $db->createCommand('select id from user where openid = :openid and status = :status')->bindValues([':openid' => $use_data['openid'], ':status' => 0])
        ->queryAll();
        if ($re) {
            return ['code' => 1005, 'data' => [], 'message' => "您已经注册过了"];
        } else {

            $re2 = $db->createCommand('select id from user where binary invite_code = :invite_code and status = :status')->bindValues([':invite_code' => $use_data['top_invite_code'], ':status' => 0])->queryOne();
            // var_dump($re2);die;
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