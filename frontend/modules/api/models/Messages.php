<?php

namespace frontend\modules\api\models;

use frontend\models\ChatMessages;
use Yii;

class Messages extends ChatMessages
{
    public function fields()
    {
        return [
          'id',
          'writer' => function ($data) {
              return $data->writer->username;
          },
            'task' => function ($data) {
                return $data->task->name;
            },
            'task_id',
            'message' => function ($data) {
                return $data->comment;
            },
            'published_at' => function ($data) {
                return $data->creation_time;
            },
            'is_mine' => function ($data) {

                return Yii::$app->user->id == $data->writer_id ? true : false;
            },


        ];
    }
//
//    public function extraFields()
//    {
//        return ['task', 'writer'];
//    }
}


