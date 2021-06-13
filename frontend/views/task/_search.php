<?php

use frontend\models\Categories;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\TaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<!--<div class="task-search">-->

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1,
        'class' => 'search-task__form'
    ],
]); ?>

<fieldset class="search-task__categories">
    <legend>Категории</legend>
    <?= $form->field($model, 'category_id')
        ->checkboxList(Categories::getList(),
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return '<input class="visually-hidden checkbox__input" 
                                      id="interview-' . $index . '" name="TaskSearch[category_id]" type="checkbox" ' .
                        $checked . ' value="' . $value . '">
                                    <label for="interview-' . $index . '">' . $label . '</label>';
                }
            ])->label('');
    ?>
</fieldset>
<fieldset class="search-task__categories">
    <legend>Дополнительно</legend>
    <?php echo $form->field($model, 'executor_id', [
        'template' => '{input}{label}',
        'options' => ['class' => ''],
    ])
        ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false)
        ->label('Без исполнителя')
    ?>
    <?php echo $form->field($model, 'location_id', [
        'template' => '{input}{label}',
        'options' => ['class' => ''],
    ])
        ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false)
        ->label('Удаленная работа')
    ?>
</fieldset>
<?php echo $form->field($model, 'created_at', [
    'template' => '{label}{input}',
    'options' => ['class' => ''],
    'labelOptions' => ['class' => 'search-task__name']
])
    ->dropDownList([
        (time() - (3600 * 24)) => 'За день',
        (time() - (3600 * 24 * 7)) => 'За неделю',
        (time() - (3600 * 24 * 30)) => 'За месяц',
        '4' => 'За все время'
    ], [
        'class' => 'multiple-select input',
        'style' => 'width: 100%',
        'prompt' => 'Выберите период'
    ])->label('Период') ?>

<?php echo $form->field($model, 'name', [
    'template' => '{label}{input}',
    'options' => ['class' => 'input-middle input'],
    'labelOptions' => ['class' => 'search-task__name']
])->label('Поиск по названию'); ?>

<?= Html::submitButton('Искать', ['class' => 'button']) ?>

<?php ActiveForm::end(); ?>
