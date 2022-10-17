<?php

namespace micro\models;

class CreditData extends \yii\base\BaseObject {


    protected $_db = null;
    public function init() {

        parent::init();
        $this->_db = \Yii::$app->getDb();
    }


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
            'mark' => (string)$data['mark']
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
        switch($data['type']) {
            case 'all':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
                }
                break;
            case 'jjwc':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and applyCompleted = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
                }
                break;
            case 'hkcg':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and applicationStatus = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
                }
                break;
            case 'jhcg':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and activated = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
                }
                break;
            case 'sscg':
                $order_ids = $this->_db->createCommand("select max(id) as bid, channelSerial from credit_card where userid = :userid and firstUsed = 'P' group by channelSerial order by bid asc")->bindValues([
                    ':userid' => $data['user_id'] ?? ""
                ])->queryAll();
                if ($order_ids) {
                    $ids = array_column($order_ids, 'bid');
                    $ids = implode(",", $ids);

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
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

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
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

                    $order_data = $this->_db->createCommand("select * from credit_card where id in (". $ids .") order by id asc")->queryAll();
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
        
        return ['code' => 0, 'data' => $order_data, 'message' => "success"];
    }



}