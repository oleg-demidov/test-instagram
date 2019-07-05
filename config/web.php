<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$route = require __DIR__.'/route.php';

$config = [
    'id' => 'basic',
    'name' => 'Instagram API',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['queue', 'log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5gma0kdoDOjGgpt6a8jDFmg4gj7HCf__',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true
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
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => $route,
        'instagram' => [
            'class' => 'app\instagram\InstagramComponent',
            'debug' => false,
            'truncatedDebug' => false,
            'storageConf' => [
                'storage'    => 'mysql',
                'dbhost'     => 'localhost',
                'dbname'     => 'instagram',
                'dbusername' => 'root',
                'dbpassword' => '23197'
            ]
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            // ...

            // retry connecting after connection has timed out
            // yiisoft/yii2-redis >=2.0.7 is required for this.
            'retries' => 1,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis', // Redis connection component or its config
            'channel' => 'queue', // Queue channel key
        ],
//        'queue' => [
//            'class' => \yii\queue\file\Queue::class,
//            'path' => '@runtime/queue',
//            'as log' => \yii\queue\LogBehavior::class
//        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
