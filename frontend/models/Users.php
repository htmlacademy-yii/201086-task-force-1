<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $creation_time
 * @property string $name
 * @property string $email
 * @property int $location_id
 * @property string|null $birthday
 * @property string|null $info
 * @property string $password
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $another_messenger
 * @property string|null $avatar
 * @property string|null $task_name
 * @property int|null $show_contacts_for_customer
 * @property int|null $hide_profile
 *
 * @property ChatMessages[] $chatMessages
 * @property EmailSettings[] $emailSettings
 * @property File[] $files
 * @property Proposal[] $proposals
 * @property Reviews[] $reviews
 * @property Reviews[] $reviews0
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property Locations $location
 * @property UsersCategories[] $usersCategories
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'birthday'], 'safe'],
            [['name', 'email', 'location_id', 'password'], 'required'],
            [['location_id', 'show_contacts_for_customer', 'hide_profile'], 'integer'],
            [['info'], 'string'],
            [['name', 'email', 'password', 'phone', 'skype', 'another_messenger', 'avatar', 'task_name'], 'string', 'max' => 128],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Locations::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creation_time' => 'Creation Time',
            'name' => 'Name',
            'email' => 'Email',
            'location_id' => 'Location ID',
            'birthday' => 'Birthday',
            'info' => 'Info',
            'password' => 'Password',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'another_messenger' => 'Another Messenger',
            'avatar' => 'Avatar',
            'task_name' => 'Task Name',
            'show_contacts_for_customer' => 'Show Contacts For Customer',
            'hide_profile' => 'Hide Profile',
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessages::className(), ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[EmailSettings]].
     *
     * @return ActiveQuery
     */
    public function getEmailSettings()
    {
        return $this->hasMany(EmailSettings::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Proposals]].
     *
     * @return ActiveQuery
     */
    public function getProposals()
    {
        return $this->hasMany(Proposal::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Reviews::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location_id']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return ActiveQuery
     */
    public function getUsersCategories()
    {
        return $this->hasMany(UsersCategories::className(), ['user_id' => 'id']);
    }
}
