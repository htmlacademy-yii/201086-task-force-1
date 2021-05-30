<?php

return [
  'basePath' => dirname(__DIR__),
  'controllerNamespace' => 'frontend\modules\api\controllers',
  'bootstrap' => ['log'],
  'modules' => [],
  'components' => [
    'request' => [
      'parsers' => [
        'application/json' => 'yii\web\JsonParser',
        'application/xml' => 'yii\web\XmlParser',
      ]
    ],
    'response' => [
      'formatters' => [
        'json' => [
          'class' => 'yii\web\JsonResponseFormatter',
          'prettyPrint' => YII_DEBUG,
          'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        ],
      ],
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => false,
      'enableSession' => false,
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
    'urlManager' => [
      'enablePrettyUrl' => true,
      'enableStrictParsing' => true,
      'showScriptName' => false,
      'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/messages', 'pluralize' => false]
      ],
    ]
  ]
];
