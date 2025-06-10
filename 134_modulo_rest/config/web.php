<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'America/Sao_Paulo',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hX3oXM9CJN6ynrX2j3-OAp7Ob2WuezDk',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class
            ]
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => \app\models\Users::class,
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
                'POST client' => 'client/index',
                'GET client/<cnpj>' => 'client/get',
                'POST carrier' => 'client/carrier',
                'GET carrier/<cnpj>/client' => 'client/get-clients',
                'POST login' => 'auth/login',
                'DELETE logout' => 'auth/logout',
                'POST harbor' => 'harbor/index',
                'PUT harbor' => 'harbor/alter-status',
                'POST os' => 'os/index',
                'GET os/<os_Id>' => 'os/get',
                'DELETE os/<os_Id>' => 'os/delete',
                'POST os/<numero_os>/multimodal' => 'travel/post',
                'os/<numero_os>/multimodal/<id_modal>' => 'travel/alter-status',
            ],
        ],
    ],
    'params' => $params,
//    'as authenticator' => [
//        'class' => \app\bases\Bearer::class
//    ]
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
