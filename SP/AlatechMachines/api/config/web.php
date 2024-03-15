<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'GfGOfS9sul596FW4mLdcP_lvHssEYGqg',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class
            ]
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON
        ],
        'cors' => [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => [
                    'http://localhost:3000/'
                ],
                'Access-Control-Request-Method' => [
                    'GET',
                    'POST',
                    'PUT',
                    'PATCH',
                    'DELETE',
                    'HEAD',
                    'OPTIONS',
                ],
                'Access-Control-Request-Headers' => [
                    '*',
                ],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Allow-Origin' => [
                    '*',
                ],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ]
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
                    'pluralize' => false,
                    'controller' => [
                        'user'
                    ],
                ],
                'GET <category>' => 'search/item',
                'GET search/<category>' => 'search/search',
                'GET images/<id>' => 'image/image',
                'POST machines' => 'machine/post',
                'DELETE machines/<id>' => 'machine/delete',
                'PUT machines/<id>' => 'machine/put',
                'POST verify-compatibility' => 'machine/verify'
            ],
        ],
    ],
    'params' => $params,
//    'as authenticator' => [
//        'class' => \app\auth\BearerToken::class,
//        'except' => [
//            'user/login',
//            'image/image',
//            'search/item'
//        ]
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
