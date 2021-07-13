<?php

namespace frontend\models;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string|null $description
 * @property int $location_id
 * @property int|null $budget
 * @property string $deadline
 * @property int $customer_id
 * @property int|null $executor_id
 * @property int|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ChatMessages[] $chatMessages
 * @property File[] $files
 * @property Proposal[] $proposals
 * @property Review[] $reviews
 * @property Categories $category
 * @property User $customer
 * @property User $executor
 * @property Locations $location
 */
class Task extends ActiveRecord
{
    const STATUS = ['Новое', 'Отменено', 'В работе', 'Выполнено', 'Провалено'];

    public $completion;
    public $completion_comment;
    public $locations;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'deadline', 'customer_id', 'created_at', 'updated_at'], 'required'],
            [
                [
                    'category_id',
                    'location_id',
                    'budget',
                    'customer_id',
                    'executor_id',
                    'created_at',
                    'updated_at',
                    'status'
                ],
                'integer'
            ],
            [['description', 'locations'], 'string'],
            [['deadline'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Categories::class,
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['executor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['executor_id' => 'id']
            ],
            [
                ['location_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Locations::class,
                'targetAttribute' => ['location_id' => 'id']
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
            'name' => 'Name',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'location_id' => 'Location ID',
            'budget' => 'Budget',
            'deadline' => 'Deadline',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessages::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Proposals]].
     *
     * @return ActiveQuery
     */
    public function getProposals()
    {
        return $this->hasMany(Proposal::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Locations::class, ['id' => 'location_id']);
    }

    public static function create($user, $array, $location_id = null)
    {

        $task = new static;
        $task->name = $array['TaskCreate']['name'];
        $task->budget = $array['TaskCreate']['budget'];
        $task->description = $array['TaskCreate']['description'];
        $task->category_id = $array['TaskCreate']['category_id'];
        $task->location_id = $location_id;
        $task->deadline = $array['TaskCreate']['deadline'];
        $task->customer_id = $user;
        $task->created_at = time();
        $task->updated_at = time();
        $task->status = 0;
        $task->save();
        return $task;
    }
}
