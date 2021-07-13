<?php


use frontend\services\MyListTasksService;
use yii\web\JqueryAsset;

$this->title = 'Мои задания';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/js/my-list.js", [
    'depends' => [
        JqueryAsset::class
    ]
]);
?>
<div class="main-container page-container">
    <section class="menu-toggle">
        <ul class="menu-toggle__list">
            <li class="menu-toggle__item menu-toggle__item--completed" data-status="done">
                <div class="menu-toggle__svg-wrapper">
                    <?php echo file_get_contents("../views/includes/over-task.php"); ?> </div>
                <a href="#">
                    Завершённые
                </a>
            </li>
            <li class="menu-toggle__item menu_toggle__item--current menu-toggle__item--new" data-status="new">
                <div class="menu-toggle__svg-wrapper"><?php echo file_get_contents("../views/includes/new-task.php"); ?></div>
                <a href="#">
                    Новые
                </a>
            </li>
            <li class="menu-toggle__item menu-toggle__item--active" data-status="in_work">
                <div class="menu-toggle__svg-wrapper"><?php echo file_get_contents("../views/includes/active-task.php"); ?></div>
                <a href="#">
                    Активные
                </a>
            </li>
            <li class="menu-toggle__item menu-toggle__item--canceled" data-status="canceled">
                <div class="menu-toggle__svg-wrapper"> <?php echo file_get_contents("../views/includes/cancel-task.php"); ?></div>
                <a href="#">
                    Отменённые
                </a>
            </li>
            <li class="menu-toggle__item menu-toggle__item--hidden" data-status="field">
                <div class="menu-toggle__svg-wrapper"> <?php echo file_get_contents("../views/includes/failed-task.php"); ?></div>
                <a href="#">
                    Проваленные
                </a>
            </li>
        </ul>
    </section>
    <section class="my-list">
        <h1>Мои задания</h1>
        <?php for ($i = 0; $i < 5; $i++) { ?>
            <div class="my-list__wrapper <?= $i == 0 ? 'active' : '' ?> <?= MyListTasksService::CLASS_LIST[$i] ?>-wrapper">
                <?= MyListTasksService::create($i, $tasks, $user) ?>
            </div>
        <?php } ?>
    </section>

</div>
