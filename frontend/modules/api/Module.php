<?php

namespace frontend\modules\api;

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
//        if (Yii::$app->user->isGuest &&  !(Yii::$app->request->isAjax ) ) {

//            throw new NotFoundHttpException('Отказ доступа');
//            return Yii::$app->response->setStatusCode(503);
//        }
        parent::init();

        // custom initialization code goes here
    }
}
