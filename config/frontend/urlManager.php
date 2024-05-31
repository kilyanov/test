<?php

use yii\web\UrlManager;
use yii\web\UrlNormalizer;

return [
    'class' => UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'normalizer' => [
        'class' => UrlNormalizer::class,
    ],
    'rules' => require('rules.php'),
    'baseUrl' => '/',
    'hostInfo' => getenv('YII_HOST_INFO'),
];
