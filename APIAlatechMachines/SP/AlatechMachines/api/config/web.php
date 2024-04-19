<?php

use yii\web\JsonResponseFormatter;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1JBqFryXqq51EwFVTL5LqK8yvrBV8UTG',
            'parsers'=>[
                'application/json'=>\yii\web\JsonParser::class
            ]
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => [
                        'search'
                    ]

                ],

                //Formatação machine controller
                'POST machines' => 'machine/post',
                'POST verify-compatibility' => 'machine/verify',
                'DELETE machines/<id>' => 'machine/delete',
                'PUT machines/<id>' => 'machine/put',


                //Formatação USER controller
                'POST login' => 'user/login',
                'DELETE logout' => 'user/logout',


                //Formatação IMAGE controller
                'GET images/<id>' => 'image/index',


                //Formatação SEARCH controller
                'GET <category>' => 'search/index',
                'GET search/<category>' => 'search/search',
                ''
            ],
        ],
    ],
    'params' => $params,
    'as authenticator' => [
        'class' => \app\Bases\BearerAuth::class,
        'response' => '',
        'except' => [
            'user/login',
            'image/index'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
