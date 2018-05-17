<?php


use yii\filters\ContentNegotiator;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/database.php';

$config = [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'app\modules\v1\Module'
        ]
    ],
    'components' => [
        'twitter' => [
            'class' => 'richweber\twitter\Twitter',
            'consumer_key' => 'qwbgKICcJBRtadEfFeBrtRJWS',
            'consumer_secret' => 'NpzbM1qUh0UF55MEz7bLNAubJpdf7TGC35gUK5Z5jcNGr6PcFr',
            'callback' => 'http://127.0.0.1:3099/api/twitter_callback',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;

                if ($response->statusCode != 200) {
                    $response->data = [
                        'error' => $response->data['message'],
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/api',
                    'pluralize' => false,
                    'patterns' => [
                        'GET' => 'index',
                        'GET add' => 'add',
                        'GET remove' => 'remove',
                        'GET feed' => 'feed',
                        'GET login' => 'login',
                        'GET callback' => 'callback',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];

return $config;
