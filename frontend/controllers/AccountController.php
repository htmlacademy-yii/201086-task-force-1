<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\Account;
use frontend\models\Categories;
use frontend\models\forms\UploadAvatarForm;
use frontend\models\UsersCategories;
use frontend\services\LocationService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * AccountController implements the CRUD actions for User model.
 */
class AccountController extends Controller
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
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {


        $model = User::find()->where(['id' => $id])->one();
        $categories = Categories::find()->asArray()->all();
        $userCategories = UsersCategories::find()->where(['user_id' => $id])
            ->joinWith(['category'])->all();
        $account = new Account();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();


            foreach ($post['Account'] as $k => $v) {
                foreach ($userCategories as $cat) {
                    if ($k == $cat->category->title_en) {
                        $cat->status = $v;
                        $cat->save();
                    }
                }
            }

            if ($post['new_pas'] !== "") {

                if ($post['new_pas'] === $post['repeat_pas']) {
                    $model->setPassword($post['new_pas']);
                }
            }
            $model->email = $post['User']['email'];
            $model->location_id = LocationService::create($post['location']);
            unset($post['location']);
            $model->info = $post['User']['info'];
            $model->phone = $post['User']['phone'];
            $model->scype = $post['User']['scype'];
            $model->another_messenger = $post['User']['another_messenger'];
            $model->birthday = strtotime($post['birthday']);
            $model->save();
        }

        return $this->render('view', [
            'model' => $model,
            'categories' => $categories,
            'userCategories' => $userCategories,
            'account' => $account
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new UploadAvatarForm();

        if (Yii::$app->request->isPost) {
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->redirect('/account/' . $id);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
