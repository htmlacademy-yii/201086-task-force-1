<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\WorkPhoto */

$this->title = 'Update Work Photo: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Work Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="work-photo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
