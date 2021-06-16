<?php


use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $task frontend\models\Task */
/* @var $fileModel frontend\models\forms\UploadForm */

$this->title = 'Публикация нового задания';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="create__task">
            <h1>Публикация нового задания</h1>
            <div class="create__task-main">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'task-form',
                    'options' => [
                        'class' => 'create__task-form form-create',
                        'enctype' => 'multipart/form-data'
                    ],
                ]) ?>
                <?= $form->field($task, 'name')->textarea([
                    'class' => 'input textarea',
                    'id' => 10,
                    'placeholder' => 'Повесить полку',
                    'rows' => 1
                ])
                    ->label('Мне нужно'); ?>
                <span>Кратко опишите суть работы</span>
                <?= $form->field($task, 'description')->textarea([
                    'class' => 'input textarea',
                    'id' => 11,
                    'placeholder' => 'Place your text',
                    'rows' => 7
                ])
                    ->label('Подробности задания'); ?>
                <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>
                <?= $form->field($task, 'category_id')
                    ->dropDownList([
                        1 => 'Курьерские услуги',
                        2 => 'Уборка',
                        3 => 'Переезды',
                        4 => 'Компьютерная помощь',
                        5 => 'Ремонт квартирный',
                        6 => 'Ремонт техники',
                        7 => 'Красота',
                        8 => 'Фото'
                    ],
                        [
                            'class' => 'multiple-select input multiple-select-big',
                            'id' => 12,
                            'size' => 1,
                            'prompt' => 'Выберите категорию'
                        ])->label('Категория'); ?>
                <span>Выберите категорию</span>
                <?= $form->field($fileModel, 'file', [
                    'template' =>
                        "<p>{label}</p><span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span><div class='create__file dz-clickable'>{input}</div>"
                ])
                    ->input('file', ['multiple' => 'true'])->label('Файлы'); ?>
                <?= $form->field($task, 'location', ['template' => "<p>{label}</p>{input}",])
                    ->input('locations', [
                        'id' => 13,
                        'class' => 'input-navigation input-middle input',
                        'placeholder' => 'Санкт-Петербург, Калининский район',
                    ])->label('Локация'); ?>
                <span>Укажите адрес исполнения, если задание требует присутствия</span>
                <div class="create__price-time">
                    <div class="create__price-time--wrapper">
                        <?= $form->field($task, 'budget')->textarea([
                            'class' => 'input textarea input-money',
                            'id' => 14,
                            'placeholder' => '1000',
                            'rows' => 1
                        ])
                            ->label('Бюджет'); ?>
                        <span>Не заполняйте для оценки исполнителем</span>
                    </div>
                    <div class="create__price-time--wrapper">
                        <?= $form->field($task, 'deadline')->input('date', [
                            'class' => 'input-middle input input-date',
                            'rows' => '1',
                            'placeholder' => '10.11, 15:00',
                        ])
                            ->label('Сроки исполнения'); ?>
                        <span>Укажите крайний срок исполнения</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                    </div>
                </div>
                <?php ActiveForm::end() ?>
                <div class="create__warnings">
                    <div class="warning-item warning-item--advice">
                        <h2>Правила хорошего описания</h2>
                        <h3>Подробности</h3>
                        <p>Друзья, не используйте случайный<br>
                            контент – ни наш, ни чей-либо еще. Заполняйте свои
                            макеты, вайрфреймы, мокапы и прототипы реальным
                            содержимым.</p>
                        <h3>Файлы</h3>
                        <p>Если загружаете фотографии объекта, то убедитесь,
                            что всё в фокусе, а фото показывает объект со всех
                            ракурсов.</p>
                    </div>
                    <div class="warning-item warning-item--error">
                        <h2>Ошибки заполнения формы</h2>
                        <?php debug($task->getErrors()); ?>

                        <h3>Категория</h3>
                        <p>Это поле должно быть выбрано.<br>
                            Задание должно принадлежать одной из категорий</p>
                    </div>
                </div>
            </div>
            <button form="task-form" class="button" type="submit">Опубликовать</button>
        </section>
    </div>
</main>
