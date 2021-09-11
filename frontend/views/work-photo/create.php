<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\WorkPhoto */
/* @var $file frontend\models\forms\UploadWorkForm */

$this->title = 'Create Work Photo';
$this->params['breadcrumbs'][] = ['label' => 'Work Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-photo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'file'=> $file
    ]) ?>

</div>
