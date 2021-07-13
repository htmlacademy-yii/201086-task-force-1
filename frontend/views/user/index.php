<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-container page-container">
    <section class="user__search">
        <div class="user__search-link">
            <p>Сортировать по:</p>
            <ul class="user__search-list">
                <li class="user__search-item user__search-item--current">
                  <?=$dataProvider->sort->link('rating', ['class' => 'link-regular',])?>
                </li>
                <li class="user__search-item">
                  <?=$dataProvider->sort->link('count_orders', ['class' => 'link-regular'])?>
                </li>
                <li class="user__search-item">
                  <?=$dataProvider->sort->link('popularity', ['class' => 'link-regular'])?>
                </li>
            </ul>
        </div>
      <?php Pjax::begin(); ?>
      <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'content-view__feedback-card user__search-wrapper'],
        'itemView' => '_list_item',
        'pager' => [
          'pageCssClass' => 'pagination__item',
          'nextPageCssClass' =>'pagination__item',
          'prevPageCssClass' =>'pagination__item',
          'activePageCssClass' => 'pagination__item--current',
          'hideOnSinglePage'=> true,
          'maxButtonCount' => 3,
          'options' => ['class' => 'new-task__pagination-list'],
          'nextPageLabel' => '&#8195',
          'prevPageLabel' => '&#8195'
        ],

      ]) ?>
      <?php Pjax::end(); ?>
    </section>


    <section  class="search-task">
        <div class="search-task__wrapper">
          <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </section>
</div>


