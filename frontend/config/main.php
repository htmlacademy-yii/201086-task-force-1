<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
  'id' => 'app-frontend',
  'basePath' => dirname(__DIR__),
  'bootstrap' => [
    'log',
  ],
  'layout' => 'layout',
  'modules' => [
//      'gii',
      'api' => [
          'class' => 'frontend\modules\api\Module',
      ],
  ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
          'csrfParam' => '_csrf-frontend',
          'parsers' => [
            'application/json' => 'yii\web\JsonParser',
          ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '<_action:login|logout>' => 'site/<_action>',
                '<_controller:[\w\-]+>' => '<_controller>/index',
                '<_controller:[\w\-]+>/<id:\d+>' => '<_controller>/view',
                '<_controller:[\w\-]+>/<_action:[\w-]+>' => '<_controller>/<_action>',
                '<_controller:[\w\-]+>/<id:\d+>/<_action:[\w-]+>' => '<_controller>/<_action>',
//                'api/<_controller:[\w\-]+>/<id:\d+>' => 'api/<_controller>/view',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/messages', 'pluralize' => false]

            ],
        ],
    ],
    'params' => $params,
];
