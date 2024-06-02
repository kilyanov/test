<?php

use yii\console\controllers\MigrateController;
use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [],
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationTable' => '{{%migration}}',
            'useTablePrefix' => true,
            'migrationPath' => [
                '@app/migrations',
                '@app/modules/organizator/migrations',
                '@app/modules/event/migrations',
            ],
            'interactive' => false,
        ],
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
 ];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}

return ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
