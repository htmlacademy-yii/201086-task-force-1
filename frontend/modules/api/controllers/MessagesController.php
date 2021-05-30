<?php


namespace frontend\modules\api\controllers;

use frontend\models\ChatMessages;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class MessagesController extends ActiveController
{
    public $modelClass = ChatMessages::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function checkAccess($action, $model = null, $params = [])
    {
        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'xml' => Response::FORMAT_XML,
                    'application/json' => Response::FORMAT_JSON,

                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
        ];
    }

    public function actionIndex()
    {
        if (!$id = Yii::$app->request->get('task_id')) {
            return false;
        }
        return ChatMessages::find()->where(['task_id' => $id])->all();
    }

    public function actionView($id)
    {
        $model = ChatMessages::find()->where(['id' => $id])->all();
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        return $model;
    }

}
