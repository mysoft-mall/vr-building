<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions' => [
        [
            'name' => 'craa\weixin-sdk',
            'alias' => [
                '@weixin' => '@app/components/weixin'
            ],
        ]
    ],
    'components' => [
        'response' => [
            'class' => 'app\components\Response',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tjUVjGXg2qff54BJkxJSlE_Vkkn1OzFn',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
            'servers' => [
                [
                   'host' => '127.0.0.1',
                   'port' => 11211,
                   'weight' => 100,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'admin/manage/index',
                'material/upload' => 'admin/material/upload',
                'material/publish' => 'admin/material/generate',
                'material/list' => 'admin/material/list',
                'material/delete' => 'admin/material/delete',
                'panorama/list' => 'admin/panorama/list',
                'panorama/delete' => 'admin/panorama/delete',
                'wx-config' => 'site/wx-config',
            ],
        ],
        'weixin'=>[
            'class' => '\weixin\Weixin',
            'debug' => true,
            'components' => [
                'account' => [
                    'token' => 'weixin',
                    'appid' => 'wx2b0939a7c90c1092',
                    'appsecret' => 'd34bb0cd5a182896f2b626b21523cbe3',
                ],
                'cache' => [
                    'class' => 'weixin\caching\FileCache',
                ]
            ],
        ],

    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
