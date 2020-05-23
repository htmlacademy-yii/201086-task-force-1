<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'creation_time',
            'name',
            'email:email',
            'location_id',
            'birthday',
            'info:ntext',
            'password',
            'phone',
            'skype',
            'another_messenger',
            'avatar',
            'task_name',
            'show_contacts_for_customer',
            'hide_profile',
            'last_visit_time',
            'rating',
            'count_orders',
            'popularity',
            'now_free',
            'has_reviews',
            'is_executor',
            'count_reviews',
        ],
    ]) ?>

</div>
