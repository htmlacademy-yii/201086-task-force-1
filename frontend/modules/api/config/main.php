<?php

return [
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\modules\api\controllers',
    'modules' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',


            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'messages', 'pluralize' => false]
            ],
        ]
    ],
    'components' => [


    ]
];
