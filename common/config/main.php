<?php
return [
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
  ],
  'modules' => [
    'api' => [
      'class' => 'modules\api\Module'
    ]
  ],
  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
  'components' => [
      'authManager' => [
        'class' => 'yii\rbac\DbManager',
      ],


  ],
];
