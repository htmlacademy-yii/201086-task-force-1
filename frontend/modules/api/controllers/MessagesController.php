<?php


namespace frontend\modules\api\controllers;


use frontend\modules\api\models\Messages;
use Yii;
use yii\web\ForbiddenHttpException;


class MessagesController extends BaseApiController
{
    public $modelClass = Messages::class;

    public function beforeAction($action)
    {
        if (in_array($action->id, ['index'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);


        return $actions;
    }

    protected function verbs()
    {
        return [
            'view' => ['GET', 'HEAD', 'POST'],
        ];
    }

    public function actionView($id)
    {
//        if (!\Yii::$app->user->id)
//            throw new \yii\web\ForbiddenHttpException(sprintf('Доступ только для авторизованных пользователей.'));
        return Messages::find()->where(['task_id' => $id])->all();
        $request = Yii::$app->request;
        if ($request->isGet) {
            if (!$id) {
                throw new ForbiddenHttpException();
            }
            return Messages::find()->where(['task_id' => $id])->all();
        }


        if ($request->isPost) {
            $message = new Messages();

            $message->writer_id = Yii::$app->user->getId();
            $message_body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
            $message->task_id = $message_body['task_id'];
            $message->comment = $message_body['message'];
            $message->viewed = 0;
            $message->creation_time = time();

            $message->save(false);
            Yii::$app->getResponse()->setStatusCode(201);
            return $message;
        }
    }

    public function actionCreate($id)
    {
        $model = new Messages();

        if ($model->load(Yii::$app->request->post(), '')) {
            $post = Yii::$app->request->post();
            $model['task_id'] = $id;
            $model->save();
            return $model;
        }

    }
////
//    public function actionView($id)
//    {
//        //TODO реализовать флаг is_mine для /messenger.js:3456
//        $model = ChatMessages::find()->where(['task_id' => $id])->all();
//
////        Yii::$app->response->format = Response::FORMAT_JSON;
//
//        return $model;
//    }
}
