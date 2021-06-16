<?php


namespace frontend\modules\api\controllers;

use frontend\models\ChatMessages;
use Yii;
use yii\web\Response;


class MessagesController extends BaseApiController
{
    public $modelClass = ChatMessages::class;


    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
//            'view' => [
//                'class' => 'yii\rest\ViewAction',
//                'modelClass' => $this->modelClass,
//                'checkAccess' => [$this, 'checkAccess'],
//            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
        ];
    }

//    public function actionIndex()
//    {
//        if (!$id = Yii::$app->request->get('task_id')) {
//            return false;
//        }
//        return ChatMessages::find()->where(['task_id' => $id])->all();
//    }
//
    public function actionView($id)
    {
        //TODO реализовать флаг is_mine для /messenger.js:3456
        $model = ChatMessages::find()->where(['task_id' => $id])->all();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $model;
    }
}
