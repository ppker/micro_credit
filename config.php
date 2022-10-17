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
                        'POST get_bank_order' => 'get_bank_order'
                    ],
                    'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'apiv1',
                    'extraPatterns' => [
                        'POST cards' => 'cards',
                        'POST user' => 'user',
                        'POST get_user' => 'get_user',
                         
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
        ]
    ],




];