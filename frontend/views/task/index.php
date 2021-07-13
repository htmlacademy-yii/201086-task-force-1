<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<div class="main-container page-container">

    <section class="new-task">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'new-task__card'],
            'itemView' => '_list_item',
            'pager' => [
                'pageCssClass' => 'pagination__item',
                'nextPageCssClass' => 'pagination__item',
                'prevPageCssClass' => 'pagination__item',
                'activePageCssClass' => 'pagination__item--current',
                'hideOnSinglePage' => true,
                'maxButtonCount' => 3,
                'options' => ['class' => 'new-task__pagination-list'],
                'nextPageLabel' => '&#8195',
                'prevPageLabel' => '&#8195',
            ],
        ]) ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </section>

</div>
<?php Pjax::end(); ?>

</div>
