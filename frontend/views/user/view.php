<?php

use common\models\User;
use frontend\classes\TimeAgo;
use frontend\models\Task;
use yii\helpers\Html;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

$tasks = Task::find()->asArray()->all();
$users = User::find()->indexBy('id')->all();

?>
<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <img src="/img/<?= $users[$model->id]->ava;?>" width="120" height="120" alt="Аватар пользователя">
                <div class="content-view__headline">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <p>Россия, Санкт-Петербург,  <?=(new TimeAgo($model->birthday))->getDate();?></p>
                    <div class="profile-mini__name five-stars__rate">
                      <? for($i = 0;$i < 5; $i++):
                        if($i < (round($model->rating / 100, 0))):
                          echo '<span></span>';
                        else:
                          echo "<span class='star-disabled'></span>";
                        endif;
                      endfor;?>
                        <b><?= round($model->rating / 100, 2);?></b>
                    </div>
                    <b class="done-task">Выполнил <?= $model->count_orders;?> заказов</b><b class="done-review">Получил <?= $model->count_reviews;?> отзывов</b>
                </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span><?="Был на сайте ".(new TimeAgo($model->last_visit_time))->getDate()." назад";?></span>
                    <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <p><?=$model->info;?></p>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <h3 class="content-view__h3">Специализации</h3>
                    <div class="link-specialization">
                      <?php
                      foreach ($model->category as $categoryItem): ?>
                          <a href="#" class="link-regular"><?=$categoryItem['title']?></a>
                      <?php endforeach; ?>
                    </div>
                    <h3 class="content-view__h3">Контакты</h3>
                    <div class="user__card-link">
                        <a class="user__card-link--tel link-regular" href="#"><?=$model->phone;?></a>
                        <a class="user__card-link--email link-regular" href="#"><?=$model->email;?></a>
                        <a class="user__card-link--skype link-regular" href="#"><?=$model->skype;?></a>
                    </div>
                </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                  <?php foreach ($model->files as $file):?>
                      <a href="#"><img src=".<?= $file['path']?>" width="85" height="86" alt="Фото работы"></a>
                  <?php endforeach;?>
                </div>
            </div>
        </div>
        <div class="content-view__feedback">
            <h2>Отзывы<span>(<?= count($model->executorReview);?>)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">
              <?php foreach ($model->executorReview as $review):?>
                  <div class="feedback-card__reviews">
                      <p class="link-task link">Задание <a href="#" class="link-regular"><?=$tasks[$review->task_id]['name']?></a></p>
                      <div class="card__review">
                          <a href="#"><img src="../<?= $users[$review->customer_id]['avatar']?>" width="55" height="54" alt=""></a>
                          <div class="feedback-card__reviews-content">
                              <p class="link-name link"><a href="#" class="link-regular"><?= $users[$review->customer_id]['name']?></a></p>
                              <p class="review-text"><?= $review->comment?></p>
                          </div>
                          <div class="card__review-rate">
                              <p class="<?php switch ($review->assessment) {
                                case 0:
                                  echo "one";
                                  break;
                                case 1:
                                  echo "one";
                                  break;
                                case 2:
                                  echo "two";
                                  break;
                                case 3:
                                  echo "three";
                                  break;
                                case 4:
                                  echo "four";
                                  break;
                                case 5:
                                  echo "five";
                                  break;
                              }?>-rate big-rate"><?= $review->assessment?><span></span></p>
                          </div>
                      </div>
                  </div>
              <?php endforeach;?>
            </div>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">
            <h3>Переписка</h3>
            <div class="chat__overflow">
                <div class="chat__message chat__message--out">
                    <p class="chat__message-time">10.05.2019, 14:56</p>
                    <p class="chat__message-text">Привет. Во сколько сможешь
                        приступить к работе?</p>
                </div>
                <div class="chat__message chat__message--in">
                    <p class="chat__message-time">10.05.2019, 14:57</p>
                    <p class="chat__message-text">На задание
                        выделены всего сутки, так что через час</p>
                </div>
                <div class="chat__message chat__message--out">
                    <p class="chat__message-time">10.05.2019, 14:57</p>
                    <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
                </div>
            </div>
            <p class="chat__your-message">Ваше сообщение</p>
            <form class="chat__form">
                <textarea class="input textarea textarea-chat" rows="2" name="message-text" placeholder="Текст сообщения"></textarea>
                <button class="button chat__button" type="submit">Отправить</button>
            </form>
        </div>
    </section>
</div>
