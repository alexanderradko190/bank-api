<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'city' => [
            'class' => 'backend\modules\city\ApiModule',
        ],
        'country' => [
            'class' => 'backend\modules\country\ApiModule',
        ],
        'bank' => [
            'class' => 'backend\modules\bank\ApiModule',
        ],
        'service' => [
            'class' => 'backend\modules\service\ApiModule',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => [
                    'class' => 'yii\web\JsonParser'
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => null,
        ],
        'session' => [
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'GET city' => 'city/city/index',
                'GET city/<id:\d+>' => 'city/city/view',
                'POST city' => 'city/city/create',
                'PATCH city/<id:\d+>' => 'city/city/update',
                'DELETE city/<id:\d+>' => 'city/city/delete',
                'GET country' => 'country/country/index',
                'GET country/<id:\d+>' => 'country/country/view',
                'POST country' => 'country/country/create',
                'PATCH country/<id:\d+>' => 'country/country/update',
                'DELETE country/<id:\d+>' => 'country/country/delete',
                'GET service' => 'service/service/index',
                'GET service/<id:\d+>' => 'service/service/view',
                'POST service' => 'service/service/create',
                'PATCH service/<id:\d+>' => 'service/service/update',
                'DELETE service/<id:\d+>' => 'service/service/delete',
                'GET bank' => 'bank/bank/index',
                'GET bank/<id:\d+>' => 'bank/bank/view',
                'POST bank' => 'bank/bank/create',
                'PATCH bank/<id:\d+>' => 'bank/bank/update',
                'DELETE bank/<id:\d+>' => 'bank/bank/delete',
            ],
        ],
    ],
    'params' => $params,
];
