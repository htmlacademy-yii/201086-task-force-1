<?php


namespace frontend\services;


use frontend\models\Task;
use Yii;

class AccountService
{
    public static function notificationChat()
    {
        $authUser = Yii::$app->user->id;
        $arrMsgs = [];
        $i = 0;
        $tasks = Task::find()
            ->where(['executor_id' => $authUser])
            ->orWhere(['customer_id' => $authUser])->all();
        foreach ($tasks as $task) {
            foreach ($task->chatMessages as $msg) {
//                debug($msg);
                if ($msg->writer_id !== $authUser and $msg->viewed == 0) {
                    $arrMsgs[$i] = [
                        'task_id' => $msg->task_id,
                        'task_name' => $task->name,
                        'writer_id' => $msg->writer_id
                    ];
                    $i++;
                }
            }

        }

        return $arrMsgs;
    }

}
