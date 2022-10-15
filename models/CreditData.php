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



}