<?php

namespace frontend\models;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chat_messages".
 *
 * @property int $id
 * @property int $task_id
 * @property int $writer_id
 * @property string|null $comment
 * @property int $creation_time
 * @property int $viewed
 *
 * @property Task $task
 * @property User $writer
 */
class ChatMessages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['task_id', 'writer_id', 'creation_time', 'viewed'], 'required'],
          [['task_id', 'writer_id', 'creation_time', 'viewed'], 'integer'],
          [['comment'], 'string'],
          [
            ['task_id'],
            'exist',
            'skipOnError' => true,
            'targetClass' => Task::class,
            'targetAttribute' => ['task_id' => 'id']
          ],
          [
            ['writer_id'],
            'exist',
            'skipOnError' => true,
            'targetClass' => User::class,
            'targetAttribute' => ['writer_id' => 'id']
          ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          'id' => 'ID',
          'task_id' => 'Task ID',
          'writer_id' => 'Writer ID',
          'comment' => 'Comment',
          'creation_time' => 'Creation Time',
          'viewed' => 'Viewed',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[Writer]].
     *
     * @return ActiveQuery
     */
    public function getWriter()
    {
        return $this->hasOne(User::class, ['id' => 'writer_id']);
    }

    public static function create($task_id, $writer_id, $comment)
    {
        $message = new static();

        $message->task_id = $task_id;
        $message->writer_id = $writer_id;
        $message->comment = $comment;
        $message->creation_time = 1;
        $message->viewed = 0;
        $message->save();
        return $message;
    }
}
