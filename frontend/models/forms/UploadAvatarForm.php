<?php

namespace frontend\models\forms;

use RuntimeException;
use Yii;
use yii\base\Model;

class UploadAvatarForm extends Model
{
    public $photo;

    public function rules()
    {
        return [
            [['photo'], 'file', 'extensions' => 'png, jpg, txt']];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->photo->saveAs('img/avatar/ava' . Yii::$app->user->id . '.' . 'jpg');
            return true;
        } else {
            throw new RuntimeException('Не получилось загрузить файл');
        }
    }
}