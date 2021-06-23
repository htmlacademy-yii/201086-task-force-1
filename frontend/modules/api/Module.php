<?php

namespace frontend\modules\api;

use Yii;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
//        if (Yii::$app->user->isGuest  ) {
//
//            throw new NotFoundHttpException('Отказ доступа');
//            return Yii::$app->response->setStatusCode(503);
//            //TODO реализовать правильное отображение ошибки
//        }
        parent::init();
        Yii::configure($this, require __DIR__ . '/config/main.php');

    }
}
