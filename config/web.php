<?php

use app\common\Request;
use yii\di\ServiceLocator;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => app\modules\admin\Module::class,
            'modules' => [
                'organizator' => [
                    'class' => app\modules\admin\modules\organizator\Module::class,
                ],
                'event' => [
                    'class' => app\modules\admin\modules\event\Module::class,
                ],
            ]
        ],
        'organizator' => [
            'class' => app\modules\organizator\Module::class,
        ],
        'event' => [
            'class' => app\modules\event\Module::class,
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('VALIDATE_KEY'),
        ],
        'user' => [
            'identityClass' => app\models\User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
