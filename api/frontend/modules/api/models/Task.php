<?php


namespace frontend\modules\api\models;


use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
  public static function tableName()
  {
    return 'task';
  }

}