<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\File;
use frontend\models\forms\UploadForm;
use frontend\models\Proposal;
use frontend\models\search\TaskSearch;
use frontend\models\Task;
use frontend\models\TaskCreate;
use frontend\services\LocationService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
//        debug( Yii::$app->request->get());
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Task::find()
            ->joinWith('location')
            ->where(['task.id' => $id])
            ->one();
        $user = User::find()->where(['id' => $model->customer_id])->one();
        $proposal = Proposal::find()
            ->joinWith('user')
            ->joinWith('task')
            ->all();
        return $this->render('view', [
            'model' => $model,
            'proposal' => $proposal,
            'user' => $user
        ]);
    }
    public function actionCreate()
    {
        $task = new TaskCreate();
        $file = new File();
        $fileModel = new UploadForm();

        if ($task->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            Task::create(Yii::$app->user->id, $post, LocationService::create($post['TaskCreate']['location']));
            $fileModel->file = UploadedFile::getInstance($fileModel, 'file');
            if((!empty($fileModel->file))&&($fileModel->upload())){
                $file::create(Yii::$app->user->id, count(Task::find()->all()),"/img/upload/".$fileModel->file->name)->save();
            }
            return $this->redirect('index');
        }

        return $this->render('create', [
            'task' => $task,
            'fileModel' => $fileModel,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AvailableActions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
