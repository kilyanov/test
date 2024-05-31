<?php

use app\common\bus\base\CopyCommand;
use app\common\bus\base\CopyHandler;
use app\common\bus\base\DeleteAllCommand;
use app\common\bus\base\DeleteAllHandler;
use app\common\bus\base\DeleteCommand;
use app\common\bus\base\DeleteHandler;
use app\common\bus\base\UpdateCommand;
use app\common\bus\base\UpdateHandler;
use app\common\bus\base\IndexCommand;
use app\common\bus\base\IndexHandler;
use app\common\bus\base\CreateCommand;
use app\common\bus\base\CreateHandler;
use app\common\Request;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\CallableLocator;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;
use League\Tactician\Plugins\LockingMiddleware;
use yii\di\Container;
use yii\di\ServiceLocator;
use yii\rbac\DbManager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'name' => 'CIL-v8',
    'language' => 'ru-RU',
    'id' => 'CIL',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \app\modules\device\Bootstrap::class,
        \app\modules\industry\Bootstrap::class,
        \app\modules\salary\Bootstrap::class,
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'container' => [
        'singletons' => [
            CommandBus::class => static function (Container $container) {
                $locator = new ServiceLocator([
                    'components' => [
                        /** Base Command Bus*/
                        IndexCommand::class => IndexHandler::class,
                        CreateCommand::class => CreateHandler::class,
                        UpdateCommand::class => UpdateHandler::class,
                        DeleteCommand::class => DeleteHandler::class,
                        DeleteAllCommand::class => DeleteAllHandler::class,
                        CopyCommand::class => CopyHandler::class,
                    ],
                ]);

                $lockingMiddleware = new LockingMiddleware();
                $commandMiddleware = new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    new CallableLocator([$locator, 'get']),
                    new InvokeInflector()
                );

                return new CommandBus([$lockingMiddleware, $commandMiddleware]);
            },
        ],
    ],
    'modules' => [
        'reference' => [
            'class' => app\modules\reference\Module::class,
        ],
        'application' => [
            'class' => app\modules\application\Module::class,
        ],
        'industry' => [
            'class' => app\modules\industry\Module::class,
        ],
        'device' => [
            'class' => app\modules\device\Module::class,
        ],
        'salary' => [
            'class' => app\modules\salary\Module::class,
        ],
    ],
    'components' => [
        'request' => [
            'class' => Request::class,
            'web' => '/web',
            'cookieValidationKey' => 'CAeYObBrPw6Bixarpd-FSRVTT3FD8JK9',
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
        'authManager' => [
            'class' => DbManager::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'device/default/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'reference/contract-specification/index/<contractId:[\w\-]+>' => 'reference/contract-specification/index',
                'reference/contract-specification/create/<contractId:[\w\-]+>' => 'reference/contract-specification/create',
                'device/device-info-verification/create/<deviceId:[\w\-]+>' => 'device/device-info-verification/create',
                'device/device-to-unit/index/<deviceId:[\w\-]+>' => 'device/device-to-unit/index',
                'device/device-to-unit/create/<deviceId:[\w\-]+>' => 'device/device-to-unit/create',
                'device/device-to-impact/index/<deviceId:[\w\-]+>' => 'device/device-to-impact/index',
                'device/device-to-impact/create/<deviceId:[\w\-]+>' => 'device/device-to-impact/create',
                'device/verification/index/<deviceId:[\w\-]+>' => 'device/verification/index',
                'device/verification/create/<deviceId:[\w\-]+>' => 'device/verification/create',
                'device/rejection/index/<deviceId:[\w\-]+>' => 'device/rejection/index',
                'device/rejection/create/<deviceId:[\w\-]+>' => 'device/rejection/create',
                'device/conservation/index/<deviceId:[\w\-]+>' => 'device/conservation/index',
                'device/conservation/create/<deviceId:[\w\-]+>' => 'device/conservation/create',
                'device/standard/create/<deviceId:[\w\-]+>' => 'device/standard/create',
                'industry/order-unit/index/<orderId:[\w\-]+>' => 'industry/order-unit/index',
                'industry/order-unit/create/<orderId:[\w\-]+>' => 'industry/order-unit/create',
                'industry/order-unit/moving/<orderId:[\w\-]+>' => 'industry/order-unit/moving',
                'industry/order-impact/index/<orderId:[\w\-]+>' => 'industry/order-impact/index',
                'industry/order-impact/create/<orderId:[\w\-]+>' => 'industry/order-impact/create',
                'industry/order-impact/moving/<orderId:[\w\-]+>' => 'industry/order-impact/moving',
                'industry/order-product/index/<orderId:[\w\-]+>' => 'industry/order-product/index',
                'industry/order-product/create/<orderId:[\w\-]+>' => 'industry/order-product/create',
                'industry/order-product/moving/<orderId:[\w\-]+>' => 'industry/order-product/moving',
                'industry/order-product-part/index/<orderId:[\w\-]+>' => 'industry/order-product-part/index',
                'industry/order-product-part/create/<orderId:[\w\-]+>' => 'industry/order-product-part/create',
                'industry/order-product-part/moving/<orderId:[\w\-]+>' => 'industry/order-product-part/moving',
                'industry/stand/view/<standId:[\w\-]+>' => 'industry/stand/view',
                'industry/rationing-device-data/index/<rationingDeviceId:[\w\-]+>' => 'industry/rationing-device-data/index',
                'industry/rationing-device-data/create/<rationingDeviceId:[\w\-]+>' => 'industry/rationing-device-data/create',
                'industry/rationing-device-data/moving/<rationingDeviceId:[\w\-]+>' => 'industry/rationing-device-data/moving',
                'industry/rationing-product-data/index/<rationingProductId:[\w\-]+>' => 'industry/rationing-product-data/index',
                'industry/rationing-product-data/create/<rationingProductId:[\w\-]+>' => 'industry/rationing-product-data/create',
                'industry/rationing-product-data/moving/<rationingProductId:[\w\-]+>' => 'industry/rationing-product-data/moving',
                'industry/rationing-product-data/machine/<rationingProductId:[\w\-]+>' => 'industry/rationing-product-data/machine',
                'industry/order-rationing/index/<orderId:[\w\-]+>' => 'industry/order-rationing/index',
                'industry/order-rationing/create/<orderId:[\w\-]+>' => 'industry/order-rationing/create',
                'industry/order-rationing-data/index/<rationingId:[\w\-]+>' => 'industry/order-rationing-data/index',
                'industry/order-rationing-data/create/<rationingId:[\w\-]+>' => 'industry/order-rationing-data/create',
                'industry/order-rationing-data/moving/<rationingId:[\w\-]+>' => 'industry/order-rationing-data/moving',
                'industry/order-rationing-data/machine/<rationingId:[\w\-]+>' => 'industry/order-rationing-data/machine',
                'industry/order-rationing-data/download/<rationingId:[\w\-]+>' => 'industry/order-rationing-data/download',
                'industry/order-rationing-data/close-norma/<id:[\w\-]+>' => 'industry/order-rationing-data/close-norma',
                'industry/order-rationing-data/close-norma-cancel/<id:[\w\-]+>' => 'industry/order-rationing-data/close-norma-cancel',
                'industry/order-rationing-data/close-norma-update/<id:[\w\-]+>' => 'industry/order-rationing-data/close-norma-update',
                'industry/order-rationing-data-close/index/<orderRationingDataId:[\w\-]+>' => 'industry/order-rationing-data-close/index',
                'industry/deduction-hour/index' => 'industry/deduction-hour/index',
                'application/data/index/<applicationId:[\w\-]+>' => 'application/data/index',
                'application/data/create/<applicationId:[\w\-]+>' => 'application/data/create',
                'salary/report-card-data/<reportCardId:[\w\-]+>' => 'salary/report-card-data/index',
                'salary/report-card-data/create/<reportCardId:[\w\-]+>' => 'salary/report-card-data/create',
                'salary/report-card-data/update-custom/<reportCardId:[\w\-]+>' => 'salary/report-card-data/update-custom',
                'salary/report-card-data/reset/<reportCardId:[\w\-]+>' => 'salary/report-card-data/reset',
                'industry/presentation-book-data-product/index/<bookId:[\w\-]+>' => 'industry/presentation-book-data-product/index',
                'industry/presentation-book-data-device-repair/index/<bookId:[\w\-]+>' => 'industry/presentation-book-data-device-repair/index',
                'industry/presentation-book-data-device-repair/create/<bookId:[\w\-]+>' => 'industry/presentation-book-data-device-repair/create',
                'salary/registry-data/index/<registryId:[\w\-]+>' => 'salary/registry-data/index',
                'salary/registry-data/create/<registryId:[\w\-]+>' => 'salary/registry-data/create',
                'salary/registry-data/moving/<registryId:[\w\-]+>' => 'salary/registry-data/moving',
                'salary/registry-data/export/<registryId:[\w\-]+>' => 'salary/registry-data/export',
                'industry/presentation-book/present-book-element/<id:[\w\-]+>' => 'industry/presentation-book/present-book-element',
                'industry/present-book-element/<bookId:[\w\-]+>' => 'industry/present-book-element/index',
                'industry/present-book-element/create/<bookId:[\w\-]+>' => 'industry/present-book-element/create',

                /**
                 * System
                 */
                '<module:[\w\-]+>' => '<module>',
                '<module:[\w\-]+>/<controller:[\w\-]+>' => '<module>/<controller>',
                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>/<page:\d+>/<per-page:\d+>' => '<module>/<controller>/<action>',
                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>/<id:[\w\-]+>' => '<module>/<controller>/<action>',
                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>' => '<module>/<controller>/<action>',
            ],
        ],

    ],
    'params' => $params,
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
