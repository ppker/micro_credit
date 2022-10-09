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
    ],
    'bank_icon' => [
        '1' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
        ],
        '2' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信银行",
        ],
        '4' => [
            'icon_name' => 'bank_gdyh',
            'bankName' => "光大银行",
        ],
        '5' => [
            'icon_name' => 'bank_pahk',
            'bankName' => "平安核卡",
        ],
        '6' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安首刷",
        ],
        '8' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
        ],
        '10' => [
            'icon_name' => 'bank_njyh',
            'bankName' => "南京银行",
        ],
        '11' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "长安银行",
        ],
        '12' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
        ],
        '13' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "中原银行全卡",
        ],
        '14' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信首刷",
        ],
        '15' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
        ],
        '17' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "广发银行激活版",
        ],
        '18' => [
            'icon_name' => 'bank_csyh',
            'bankName' => "长沙银行",
        ],
        '19' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "邮政银行",
        ],
        '20' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "汉口银行",
        ],
        '21' => [
            'icon_name' => 'bank_bbwyh',
            'bankName' => "北部湾银行",
        ],
        '22' => [
            'icon_name' => 'bank_bhyh',
            'bankName' => "渤海激活",
        ],
        '23' => [
            'icon_name' => 'bank_gzyh',
            'bankName' => "广州银行",
        ],
        '24' => [
            'icon_name' => 'bank_tjyh',
            'bankName' => "天津银行",
        ],
        '25' => [
            'icon_name' => 'bank_sjyh',
            'bankName' => "盛京银行",
        ],
        '26' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "兴业激活",
        ],
        '27' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "兴业首刷",
        ],
        '28' => [
            'icon_name' => 'bank_shyh',
            'bankName' => "上海核卡+首刷",
        ],
        '29' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "深圳农商",
        ],
        '30' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "锦州银行",
        ],
        '31' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "郑州银行",
        ],
        '32' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "杭州银行",
        ],
        
        '33' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "山西农信",
        ],

        '34' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "甘肃银行",
        ],

        '31' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "郑州银行",
        ],

        '35' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "晋商银行",
        ],

        '36' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "黄河农商",
        ],

        '37' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "齐鲁激活",
        ],

        '38' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "江西银行",
        ],

        '39' => [
            'icon_name' => 'bank_jsyh',
            'bankName' => "建设银行",
        ],

        '40' => [
            'icon_name' => 'bank_gdyh',
            'bankName' => "光大银行",
        ],

        '41' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信核卡",
        ],

        '42' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
        ],

        '43' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏海航联名信用卡",
        ],

        '44' => [
            'icon_name' => 'bank_jsyh',
            'bankName' => "建设银行",
        ],

        '45' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "浦发银行",
        ],

        '46' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信首刷",
        ],

        '48' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "中原京东",
        ],

        '49' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
        ],

        '50' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
        ],

        '51' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
        ],

        '52' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "民生核卡",
        ],

        '53' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "民生激活",
        ],

        '54' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => '华夏银行',
        ]
    ]


];