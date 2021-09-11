<?php

namespace frontend\models\forms;

use RuntimeException;
use yii\base\Model;

class UploadWorkForm extends Model
{
  public $file;
  public $path;

  public function rules()
  {
    return [
      [['file'], 'file', 'extensions' => 'png, jpg, txt']];
  }

  public function upload()
  {
    if ($this->validate()) {
        $this->path = 'img/uploads/' . $this->file->baseName . '.' . $this->file->extension;
      $this->file->saveAs($this->path);
      return true;
    } else {
        throw new RuntimeException('Не получилось загрузить файл');
    }
  }
}
