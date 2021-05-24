<?php

namespace frontend\models;



use common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_categories".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 */
class UsersCategories extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_categories';
    }

    public function afterSave($insert, $changedAttributes)
    {

        $models = UsersCategories::find()->where(['user_id' => $this->user_id])->all();
        $is_executor = 0;
        foreach ($models as $model) {
            if ($model->status == 1) {
                $is_executor = 1;
            }
        }
        $user = User::find()->where(['id' => $this->user_id])->one();
        if ($is_executor > 0) {
            $user->is_executor = 1;
        } else {
            $user->is_executor = 0;
        }
        $user->save();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id'], 'required'],
            [['user_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Categories ID',
        ];
    }

    public static function create($user_id, $category_id)
    {
        $user_category = new static();
        $user_category->user_id = $user_id;
        $user_category->category_id = $category_id;
        $user_category->save();
    }

    public static function fill($id)
    {
        for ($i = 0; $i < 8; $i++) {
            self::create($id, $i + 1);
        }
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }
}
