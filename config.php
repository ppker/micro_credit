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
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=credit_app',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],

    'components' => [

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
            ],
        ],

        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ]
    ],




];