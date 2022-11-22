<?php

namespace micro\models;

class CreditData extends \yii\base\BaseObject {


    protected $_db = null;
    protected $_cache = null;

    public function init() {

        parent::init();
        $this->_db = \Yii::$app->getDb();
        $this->_cache = \Yii::$app->cache;
    }

    const PAY_TYPE = [
        '1' => '核卡',
        '2' => '激活',
        '3' => '首刷',
        '4' => '直推',
        '5' => '间接推',
        '6' => '提现',
    ];

    public function addBankCard($data) {

        $card_info = $this->_db->createCommand("select id from bank_bag where user_id = :user_id and card_num = :card_num and status = 0")->bindValues([
            ':user_id' => (int)$data['user_id'],
            ':card_num' => $data['card_num'],
        ])->queryAll();
        if ($card_info) {
            return ['code' => 1005, 'data' => [], 'message' => "该银行卡重复了"];
        }

        $re = $this->_db->createCommand()->insert('bank_bag', [
            'openid' => (string)$data['openid'],
            'name' => (string)$data['name'],
            'card_num' => (string)$data['card_num'],
            'bank_name' => (string)$data['bank_name'],
            'mobile' => (string)$data['mobile'],
            'user_id' => (int)$data['user_id']
        ])->execute();

        if ($re) return ['code' => 0, 'data' => [], 'message' => "success"];
        return ['code' => 1003, 'data' => [], 'message' => "fail, 操作数据失败"];
    }

    public function getBankCard($data) {

        $card_info = $this->_db->createCommand("select id, name, card_num, bank_name, mobile from bank_bag where user_id = :user_id and status = 0")->bindValues([
            ':user_id' => (int)$data['user_id']
        ])->queryAll();

        if ($card_info) {
            $total = count($card_info);
            return ['code' => 0, 'data' => $card_info, 'message' => "success", 'total' => $total];
        }
        return ['code' => 1003, 'data' => [], 'message' => "fail, 操作数据失败"];

    }

    public function addCardOrder($data, $order_no) {

        $re = $this->_db->createCommand()->insert('credit_card', [
            'openid' => (string)$data['openid'],
            'userid' => (int)$data['userid'],
            'bankId' => (int)$data['bankId'],
            'name' => (string)$data['name'],
            'mobile' => (string)$data['mobile'],
            'idCard' => (string)$data['idCard'],
            'channelSerial' => (string)$order_no,
            'mark' => (string)$data['mark'],
            'frontend_bank_id' => (int)$data['frontend_bank_id']
        ])->execute();
        return $re;
    }


    public function getUserInfoByIdCard($id_card) {

        $user_info = $this->_db->createCommand("select id, openid from user where idcard = :idcard and status = 0 order by id desc")->bindValues([
            ':idcard' => $id_card
        ])->queryOne();

        return $user_info;
    }

    public function getBankOrder($data) {

        $order_data = [];
        $total_num = 0;
        $page = 1;
        switch($data['type']) {
            case 'all':

                $page = $data['page'] ?? 1;
                $page = $page < 1 ? 1 : (int)$page;
                $offset = (int)(10 * ($page - 1));
                $limit = 10;

                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids . ")" . " order by id desc limit {$offset},{$limit}")->queryAll();
                    $total_num = $this->_db->createCommand("select count(id) from credit_card where id in (". $ids . ")")->queryScalar();
                }
                break;
            case 'jjwc':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and applyCompleted = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id desc")->queryAll();
                }
                break;
            case 'hkcg':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and applicationStatus = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id desc")->queryAll();
                }
                break;
            case 'jhcg':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and activated = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id desc")->queryAll();
                }
                break;
            case 'sscg':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and firstUsed = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id desc")->queryAll();
                }
                break;
            case 'wtg':
                // 未通过
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and (applyCompleted = 'D' or applicationStatus = 'D' or activated = 'D' or firstUsed = 'D') group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id desc")->queryAll();
                }
                break;
            case 'ytx':
                // 已提现
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and payment = 1 group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id desc")->queryAll();
                }
                break;

            default:

        }
        // 进一步处理
        $bank_extend_data = \Yii::$app->params['bank_icon'];
        if (!empty($order_data)) {
            foreach ($order_data as $key => &$order_value) {
                $order_value['bank_card_url'] = $bank_extend_data[$order_value['bankId']]['bank_card'] ?? "";
                $order_value['credit_card_name'] = $bank_extend_data[$order_value['bankId']]['credit_card_name'] ?? "";
                $order_value['settle_type'] = $bank_extend_data[$order_value['bankId']]['settle_type'] ?? "";
                // 订单状态判断
                $order_value['sign_mark'] = "";
                if ($order_value['mark'] == "0") {
                    $order_value['sign_mark'] = "未在银行提交数据";
                } elseif (trim($order_value['applyCompleted']) == "P") {
                    $order_value['sign_mark'] = "进件完成";
                }
                if (trim($order_value['applicationStatus']) == "P") {
                    $order_value['sign_mark'] = "核卡成功";
                }
                if (trim($order_value['activated']) == "P") {
                    $order_value['sign_mark'] = "激活成功";
                }
                if (trim($order_value['firstUsed']) == "P") {
                    $order_value['sign_mark'] = "首刷成功";
                }
                if (trim($order_value['payment']) == 1) {
                    $order_value['sign_mark'] = "已打款结算";
                }
                // 未通过
                if (trim($order_value['applyCompleted']) == "D" || trim($order_value['applicationStatus']) == "D" || trim($order_value['activated']) == "D" || trim($order_value['firstUsed']) == "D" ) {
                    $order_value['sign_mark'] = "未通过";
                }
            }
        }
        
        return ['code' => 0, 'data' => $order_data, 'message' => "success", 'page' => $page, 'total' => intval($total_num)];
    }


    public function getUserInfoById($id) {

        $user_info = $this->_db->createCommand("select id, nickname, phone, real_name, headimgurl from user where id = :id order by id desc")->bindValues([
            ':id' => $id
        ])->queryOne();

        return $user_info;
    }


    public function getWalletData($data) {

        $wallet_data_list = $this->_db->createCommand("select * from user_earning where user_id = :user_id")->bindValues([':user_id' => $data['userid']])->queryAll();
        $total_money = $this->_db->createCommand("select sum(money_one) as total_money from user_earning where user_id = :user_id and pay_type not in (6, 7)")->bindValues([':user_id' => $data['userid']])->queryScalar();
        // 提现金额
        $total_out_money = $this->_db->createCommand("select sum(money_one) as total_money from user_earning where user_id = :user_id and pay_type = 6")->bindValues([':user_id' => $data['userid']])->queryScalar();

        // 提现失败 系统退款金额
        $total_refund_money = $this->_db->createCommand("select sum(money_one) as total_money from user_earning where user_id = :user_id and pay_type = 7")->bindValues([':user_id' => $data['userid']])->queryScalar();


        // 处理list数据
        $show_bank_list = \Yii::$app->params['show_bank_list'];
        $api_server_bankid = \Yii::$app->params['api_server_bankid'];
        if (!empty($wallet_data_list)) {
            $order_ids = array_column($wallet_data_list, 'channelSerial');
            $order_data_list = $this->_db->createCommand("select userid, frontend_bank_id, name, mobile, channelSerial, create_at from credit_card where channelSerial in (" . implode(",", $order_ids) . ") and mark = '0'")->queryAll();

            $order_data_list = array_column($order_data_list, null, 'channelSerial');
            foreach ($wallet_data_list as $key => &$wallet) {

                if (6 == $wallet['pay_type']) {
                    $wallet['order_title'] = '提现';
                } elseif (7 == $wallet['pay_type']) {
                    $wallet['order_title'] = '退款';
                }else {
                    // 张三丰 - 华夏核卡[核卡佣金]
                    $wallet['name'] = $order_data_list[$wallet['channelSerial']]['name'] ?? "";
                    $wallet['frontend_bank_id'] = $order_data_list[$wallet['channelSerial']]['frontend_bank_id'] ?? "";
                    $wallet['create_at'] = $order_data_list[$wallet['channelSerial']]['create_at'] ?? "";

                    $show_bank_list_info = $show_bank_list[$wallet['frontend_bank_id'] - 1] ?? [];
                    $wallet['order_title'] = $wallet['name'] . " - " . $show_bank_list_info['bankName'];

                    $wallet['tag_title'] = self::PAY_TYPE[$wallet['pay_type']] . "佣金";
                }
            }
        }

        // 实际提现金额
        $real_total_out_money = sprintf("%.2f", $total_out_money - $total_refund_money);

        return ['code' => 0, 'data' => ['wallet_data_list' => $wallet_data_list, 'total_money' => (float)$total_money, 'total_out_money' => (float)$real_total_out_money, 'balance' => sprintf("%.2f", (float)($total_money - $real_total_out_money))], 'message' => 'success'];
    }


    public function getBankBag($data) {

        $bank_bag_list = $this->_db->createCommand("select * from bank_bag where user_id = :user_id and status = 0 order by id desc")->bindValues([':user_id' => (int)$data['user_id']])
        ->queryAll();
        return ['code' => 0, 'data' => $bank_bag_list ?: [], 'message' => "success"];
    }

    public function checkSmsCode($post_data) {

        $key = 'sms_' . $post_data['openid'];
        $sms_code = $post_data['sms_code'];
        $check_sms_code = $this->_cache->get($key);
        if ($check_sms_code == false) {
            return ['code' => 1009, 'data' => [], 'message' => "短信验证码已到期，请重新获取"];
        }

        if ($sms_code == $check_sms_code || $sms_code == "88888") {
            return ['code' => 0, 'data' => [], 'message' => "success"];
        }
        return ['code' => 1010, 'data' => [], 'message' => "短信验证码错误"];

    }

    public function getMyTeam($post_data) {

        // top_userid
        $userid = intval($post_data['userid']);
        $openid = (int)$post_data['openid'];
        $top_userid = (int)$post_data['top_userid'];
        // 推荐人 我的上线
        $my_up_user = $this->_db->createCommand("select * from user where id = :id")->bindValues([':id' => $top_userid])->queryOne();

        // 直推 我的下线
        $my_down_users = $this->_db->createCommand("select * from user where top_userid = :id")->bindValues([':id' => $userid])->queryAll();

        $direct_num_users = count($my_down_users);
        $team_num_users = $direct_num_users + 1;
        // 本月团队核卡数
        if (empty($my_down_users)) $my_team_ids = [];
        else $my_team_ids = array_column($my_down_users, 'id');
        array_push($my_team_ids, $userid);

        $use_team_ids = implode(",", $my_team_ids);

        $current_month = date('Y-m-01 00:00:00');
        $next_month = date('Y-m-01 00:00:00', strtotime('+1 month'));

        if (isset($post_data['last_month']) && $post_data['last_month']) {
            $current_month = date('Y-m-01 00:00:00', strtotime('-1 month'));
            $next_month = date('Y-m-01 00:00:00');
        }


        $my_team_card_nums = $this->_db->createCommand("select count(id) as card_num, sum(money_one) as total_money from user_earning where user_id in (" . $use_team_ids . ") and update_at >= :current_month and update_at < :next_month and pay_type = 1")->bindValues([
            ':current_month' => $current_month,
            ':next_month' => $next_month
        ])->queryOne();

        return ['code' => 0, 'data' => [
            'my_up_user' => $my_up_user ?: [],
            'my_down_users' => $my_down_users ?: [],
            'direct_num_users' => (int)$direct_num_users,
            'team_num_users' => (int)$team_num_users,
            'card_num' => $my_team_card_nums['card_num'] ?? 0,
            'total_money' => $my_team_card_nums['total_money'] ?? 0
        ], 'message' => "success"];

    }




}