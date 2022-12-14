<?php
return [
    'id' => 'micro-credit',
    // the basePath of the application will be the `micro-app` directory
    'basePath' => __DIR__,
    // this is where the application will find all controllers
    'controllerNamespace' => 'micro\controllers',
    // set an alias to enable autoloading of classes from the 'micro' namespace
    'aliases' => [
        '@micro' => __DIR__,
    ],

    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',

    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=credit_app',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user',
                    'extraPatterns' => [
                        'GET,POST hi' => 'hi',
                    ],
                    'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'post',
                    'extraPatterns' => [
                        'GET,POST hi' => 'hi',
                    ],
                    'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'go',
                    'extraPatterns' => [
                        'GET,POST init' => 'init',
                        'GET,POST get_access_token' => 'get_access_token',
                        'GET,POST get_wx_user' => 'get_wx_user',
                        'GET,POST aes_encrypt' => 'aes_encrypt',
                        'GET,POST aes_decrypt' => 'aes_decrypt',
                        'GET,POST get_bank_list' => 'get_bank_list',
                        'GET,POST make_card' => 'make_card',
                        'POST get_bank' => 'get_bank',
                        'POST add_bank_card' => 'add_bank_card',
                        'POST get_bank_card' => 'get_bank_card',
                        'POST get_bank_order' => 'get_bank_order',
                        'POST get_team' => 'get_team',
                        'GET,POST get_new_bank_list' => 'get_new_bank_list',
                        'POST get_wallet' => 'get_wallet',
                        'GET,POST pay_to' => 'pay_to',
                        'POST get_bank_bag' => 'get_bank_bag',
                        'POST withdraw' => 'withdraw',
                        'GET,POST send_sms' => 'send_sms',
                        'POST get_name_pinyin' => 'get_name_pinyin',
                        'POST get_new_bank_list2' => 'get_new_bank_list2',
                        'POST get_vip_apply' => 'get_vip_apply',
                        'POST get_quick_pass' => 'get_quick_pass',
                        'POST get_poster_bank' => 'get_poster_bank',

                    ],
                    'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'apiv1',
                    'extraPatterns' => [
                        'POST cards' => 'cards',
                        'POST user' => 'user',
                        'POST get_user' => 'get_user',
                        'POST get_user_id' => 'get_user_id',
                        'POST pay_result' => 'pay_result',
                         
                    ],
                    'pluralize' => false,
                ],
            ],
        ],

        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'log' => [
            // 'traceLevel' => 3,
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'levels' => ['info', 'error', 'warning'],
                    'logFile' => '@app/runtime/logs/api/'.date('Ymd').'api.log',
                    'logVars' => [],
                    'categories' => [
                        'api',
                    ]
                ],
            ],
        ],



    ],




];