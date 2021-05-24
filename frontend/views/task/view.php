<?php

use Carbon\Carbon;
use common\models\User;
use frontend\classes\AvailableActions;
use frontend\classes\TimeAgo;
use frontend\models\Proposal;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\models\Task */
/* @var $user User */
/* @var $proposal frontend\models\Proposal */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
Carbon::now('Europe/Kiev');

Carbon::setLocale('ru');

//echo Yii::$app->formatter->asRelativeTime('02.03.2021');
//echo Carbon::create('02.03.2021')->diffForHumans();
?>
<div class="main-container page-container">
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= $model->name ?></h1>
                        <span>Размещено в категории
                            <a href="#" class="link-regular"><?= $model->category->title ?></a>
                            <?= Carbon::create($model->created_at)->diffForHumans(); ?> назад</span>
                    </div>
                    <b class="new-task__price new-task__price--<?= $model->category->title_en ?> content-view-price"><?= $model->budget ?>
                        <b> ₽</b></b>
                    <div class="new-task__icon new-task__icon--<?= $model->category->title_en ?> content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p><?= $model->description ?></p>
                </div>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>
                    <a href="#">my_picture.jpeg</a>
                    <a href="#">agreement.docx</a>
                </div>
                <div class="content-view__location">
                    <h3 class="content-view__h3">Расположение</h3>
                    <div class="content-view__location-wrapper">
                        <div class="content-view__map" id="map" style="width: 361px; height: 292px;"
                             data-lat="<?= $model->location->lat ?>" data-long="<?= $model->location->long ?>"></div>
                        <div class="content-view__address">
                            <span class="address__town"><?= $model->location->city ?></span><br>

                            <!--<span class="address__town">Москва</span><br>
                            <span>Новый арбат, 23 к. 1</span>
                            <p>Вход под арку, код домофона 1122</p>-->
                        </div>
                    </div>
                </div>
                <script>


                </script>
            </div>
            <div class="content-view__action-buttons">
                <?php if (AvailableActions::getActions(Yii::$app->user->identity->id, $model) == 'respond') { ?>
                    <?php Modal::begin([
                      'header' => '<h2>Отклик на задание</h2>',
                      'toggleButton' => [
                        'label' => 'Откликнуться',
                        'tag' => 'button',
                        'type' => 'button',
                        'class' => 'button button__big-color response-button',
                      ],
                      'closeButton' => [
                        'label' => 'Закрыть',
                        'tag' => 'button',
                        'class' => 'form-modal-close',
                        'id' => 'close-modal'
                      ],
                      'options' => [
                        'tag' => 'section',
                        'class' => 'modal response-form form-modal'
                      ],
                    ]); ?>
                    <?php $form = ActiveForm::begin([
                      'method' => 'get',
                      'action' => Url::to([
                        'task/proposal',
                        'task' => $model->id,
                        'us' => Yii::$app->user->identity->id
                      ])
                    ]); ?>
                    <?= $form->field($model, 'budget')->textInput([
                      'class' => 'response-form-payment input input-middle input-money',
                      'id' => 'response-payment',
                      'name' => 'response-payment',
                    ])->label('Ваша цена', ['class' => 'form-modal-description']); ?>

                    <?= $form->field($model, 'name')->textarea([
                      'class' => 'input textarea',
                      'id' => "response-comment",
                      'placeholder' => 'Place your text',
                      'name' => 'response-comment',
                      'rows' => 4
                    ])->label('Комментарий', ['class' => 'form-modal-description']); ?>
                    <?= Html::submitButton('Отправить', ['class' => 'button modal-button']) ?>
                    <?php ActiveForm::end(); ?>
                    <?php Modal::end() ?>
                <?php } ?>
                <?php if (AvailableActions::getActions(Yii::$app->user->identity->id, $model) == 'cancel') { ?>
                    <?php Modal::begin([
                      'header' => '<h2>Отменить задание</h2>',
                      'toggleButton' => [
                        'label' => 'Отменить',
                        'tag' => 'button',
                        'type' => 'button',
                        'class' => 'button button__big-color refusal-button',
                      ],
                      'closeButton' => [
                        'label' => 'Закрыть',
                        'tag' => 'button',
                        'class' => 'form-modal-close',
                        'id' => 'close-modal'
                      ],
                      'options' => [
                        'tag' => 'section',
                        'class' => 'modal form-modal refusal-form'
                      ],
                    ]); ?>
                    <p class="refusal-form-p">
                        Вы собираетесь отменить задание.
                        Вы уверены?</p>
                    <?= Html::a('Отменить', Url::to(['task/cancel', 'task' => $model->id]),
                      ['class' => 'button__form-modal button']) ?>
                    <?= Html::a('Отказаться', Url::to([Yii::$app->request->referrer]),
                      ['class' => 'button__form-modal refusal-button button']) ?>
                    <?php Modal::end() ?>
                <?php } ?>
                <?php if (AvailableActions::getActions(Yii::$app->user->identity->id, $model) == 'refuse') { ?>
                    <?php Modal::begin([
                      'header' => '<h2>Отказ от задания</h2>',
                      'toggleButton' => [
                        'label' => 'Отказаться',
                        'tag' => 'button',
                        'type' => 'button',
                        'class' => 'button button__big-color refusal-button',
                      ],
                      'closeButton' => [
                        'label' => 'Закрыть',
                        'tag' => 'button',
                        'class' => 'form-modal-close',
                        'id' => 'close-modal'
                      ],
                      'options' => [
                        'tag' => 'section',
                        'class' => 'modal form-modal refusal-form'
                      ],
                    ]); ?>
                    <p class="refusal-form-p">
                        Вы собираетесь отказаться от выполнения задания.
                        Это действие приведёт к снижению вашего рейтинга.
                        Вы уверены?</p>
                    <?= Html::a('Отказаться', Url::to(['task/refus', 'task' => $model->id]),
                      ['class' => 'button__form-modal button']) ?>
                    <?= Html::a('Отменить', Url::to([Yii::$app->request->referrer]),
                      ['class' => 'button__form-modal refusal-button button']) ?>

                    <?php Modal::end() ?>
                <?php } ?>
                <?php if (AvailableActions::getActions(Yii::$app->user->identity->id, $model) == 'done') { ?>
                    <?php Modal::begin([
                      'header' => '<h2>Завершение задания</h2>',
                      'toggleButton' => [
                        'label' => 'Завершить',
                        'tag' => 'button',
                        'type' => 'button',
                        'class' => 'button button__big-color request-button',
                      ],
                      'closeButton' => [
                        'label' => 'Закрыть',
                        'tag' => 'button',
                        'class' => 'form-modal-close',
                        'id' => 'close-modal'
                      ],
                      'options' => [
                        'tag' => 'section',
                        'class' => 'modal completion-form form-modal'
                      ],
                    ]); ?>
                    <p class="form-modal-description">Задание выполнено?</p>
                    <?php $form = ActiveForm::begin([
                      'method' => 'get',
                      'action' => Url::to(['task/completion', 'task' => $model->id])
                    ]); ?>
                    <div class="completion-group" style="display: flex">
                        <?= $form->field($model, 'completion')->radio([
                          'class' => 'visually-hidden completion-input completion-input--yes',
                          'id' => 'completion-radio--yes',
                          'label' => 'Да',
                          'labelOptions' => ['class' => 'completion-label completion-label--yes']
                        ]); ?>
                        <?= $form->field($model, 'completion')->radio([
                          'class' => 'visually-hidden completion-input completion-input--difficult',
                          'id' => 'completion-radio--yet',
                          'label' => 'Возникли проблемы',
                          'labelOptions' => [
                            'class' => 'completion-label completion-label--difficult',
                            'style' => 'margin-left:5px;'
                          ]
                        ]); ?>
                    </div>
                    <p><?= $form->field($model, 'completion_comment')->textarea([
                          'class' => 'input textarea',
                          'rows' => 4,
                          'placeholder' => 'Place your text',
                          'id' => 'completion-comment'
                        ])->label('Комментарий', ['class' => 'form-modal-description']); ?></p>

                    <p class="form-modal-description"> Оценка</p>
                    <div class="feedback-card__top--name completion-form-star">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span class="star-disabled"></span>
                    </div>

                    <?= Html::submitButton('Отправить', ['class' => 'button modal-button']); ?>
                    <?php ActiveForm::end(); ?>
                    <?php Modal::end() ?>
                <?php } ?>
                <button class="button button__big-color connection-button"
                        type="button">Написать сообщение
                </button>
            </div>
        </div>

        <?php
        if (Proposal::isProposal(Yii::$app->user->identity->id) || Yii::$app->user->identity->id == $user->id) {
            ?>
            <div class="content-view__feedback">
                <h2>Отклики <span>(<?= count($proposal) ?>)</span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($proposal as $proposalItem) { ?>
                        <?php if (Yii::$app->user->identity->id == $user->id || (Yii::$app->user->identity->id == $proposalItem->user_id && $model->id == $proposalItem->task_id)) { ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="user/1"><img src="/img/<?= $proposalItem->user->ava ?>" width="55"
                                                          height="55"></a>
                                    <div class="feedback-card__top--name">
                                        <p><a href="#" class="link-regular"><?= $proposalItem->user->username ?></a></p>
                                        <span></span><span></span><span></span><span></span><span
                                                class="star-disabled"></span>
                                        <b>4.25</b>
                                    </div>
                                    <span class="new-task__time"><?= (new TimeAgo($proposal->created_at))->getDate(); ?> назад</span>
                                </div>
                                <div class="feedback-card__content">
                                    <p><?= $proposalItem->comment ?></p>
                                    <span><?= $proposalItem->budget ?> ₽</span>
                                </div>
                                <?php if ((Yii::$app->user->identity->id == $user->id) && ($proposalItem->response == 0) && ($model->status == 0)) { ?>
                                    <div class="feedback-card__actions">
                                        <?= Html::a('Откликнуться', Url::to([
                                          'task/respond',
                                          'task' => $proposalItem->task_id,
                                          'us' => $proposalItem->user->id
                                        ]), ['class' => 'button__small-color response-button button']) ?>
                                        <?= Html::a('Отказаться', Url::to([
                                          'task/denied',
                                          'task' => $proposalItem->task_id,
                                          'us' => $proposalItem->user->id
                                        ]), ['class' => 'button__small-color refusal-button button']) ?>
                                        <button class="button__chat button"
                                                type="button"></button>
                                    </div>
                                <?php } elseif ($proposalItem->response == 2) { ?>
                                    <h2 style="text-align: right; color: gold; background-color: transparent">
                                        Исполнитель</h2>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <div class="profile-mini__top">
                    <img src="/img/<?= $user->ava ?>" width="62" height="62" alt="Аватар заказчика">
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= $user->username; ?></p>
                        <?php for ($i = 0; $i < 5; $i++):
                            if ($i < round($user->rating / 100, 0)): ?>
                                '<span></span>
                            <?php else: ?>
                                <span class='star-disabled'></span>
                            <?php endif;
                        endfor; ?>
                        <b><?= round($user->rating / 100, 2); ?></b>
                    </div>
                </div>
                <p class="info-customer"><span>15 отзывов</span><span class="last-">28 заказов</span></p>
                <a href="#" class="link-regular">Смотреть профиль</a>
            </div>
        </div>
        <div id="chat-container">
            <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
            <chat class="connect-desk__chat" task="<?= $model->id ?>"></chat>
        </div>
    </section>
</div>
