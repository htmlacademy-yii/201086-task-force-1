<?php


namespace frontend\services;


use frontend\models\Task;
use yii\helpers\Url;

class MyListTasksService
{
    const CLASS_LIST = ['new', 'canceled', 'in_work', 'done', 'field'];

    public static function create($status, $tasks, $user)
    {
        if ($tasks !== null) {
            foreach ($tasks as $task) {
                if ($task->status == $status) {
                    ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <a href="<?= Url::to(['task/view', 'id' => $task->id]) ?>" class="link-regular">
                                <h2><?= $task->name ?></h2></a>
                            <a class="new-task__type link-regular" href="#"><p><?= $task->category->title ?></p></a>
                        </div>
                        <div class="task-status <?= self::CLASS_LIST[$status] ?>-status"><?= Task::STATUS[$task->status] ?></div>
                        <p class="new-task_description"><?= $task->description ?></p>
                        <?php if ($user->is_executor) { ?>
                            <div class="feedback-card__top ">
                                <a href="<?= Url::to(['user/view', 'id' => $task->customer->id]) ?>"><img
                                            src="/img/<?= $task->customer->ava ?>" width="36" height="36"></a>
                                <div class="feedback-card__top--name my-list__bottom">
                                    <p class="link-name"><a
                                                href="<?= Url::to(['user/view', 'id' => $task->customer->id]) ?>"
                                                class="link-regular"><?= $task->customer->username ?></a></p>
                                    <a href="<?= Url::to(['task/view', 'id' => $task->id]) ?>"
                                       class="my-list__bottom-chat  my-list__bottom-chat--new"><b><?= count($task->chatMessages) ?></b></a>
                                    <span></span><span></span><span></span><span></span><span
                                            class="star-disabled"></span>
                                    <b>4.25</b>
                                </div>
                            </div>
                        <?php } else {
                            if ($task->executor !== null) {
                                ?>
                                <div class="feedback-card__top ">
                                    <a href="<?= Url::to(['user/view', 'id' => $task->executor->id]) ?>"><img
                                                src="/img/<?= $task->executor->ava ?>" width="36" height="36"></a>
                                    <div class="feedback-card__top--name my-list__bottom">
                                        <p class="link-name"><a
                                                    href="<?= Url::to(['user/view', 'id' => $task->executor->id]) ?>"
                                                    class="link-regular"><?= $task->executor->username ?></a></p>
                                        <a href="<?= Url::to(['task/view', 'id' => $task->id]) ?>"
                                           class="my-list__bottom-chat  my-list__bottom-chat--new"><b><?= count($task->chatMessages) ?></b></a>
                                        <span></span><span></span><span></span><span></span><span
                                                class="star-disabled"></span>
                                        <b>4.25</b>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="feedback-card__top ">
                                    <span style="background-color: red; color: gold">     Исполнитель не назначен    </span>
                                </div>
                            <?php }
                        } ?>

                    </div>

                <?php }
            }
        }

    }

}
