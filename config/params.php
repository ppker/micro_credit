<?php

return [


    'wx' => [
        'mp' => [
            'app_id' => '',
            'secret' => '',
            'token' => '',
            'encodingAESKey' => '',
            'safeMode' => 0
        ],


        # 微信支付
        'payment'=>[
            'mch_id'        =>  '', # 商户ID
            'key'           =>  '', # 商户KEY
            'notify_url'    =>  '', # 支付通知地址
            'cert_path'     => '', # 证书
            'key_path'      => '', # 证书
        ],

        # web 授权
        'oauth' => [
            'scopes'   => 'snsapi_userinfo', # 授权范围
            'callback' => '', # 授权回调
        ],

    ],
    'bank_params' => [
        'aes_key' => '',
        'channelCode' => '',
    ]


];