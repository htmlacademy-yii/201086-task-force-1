<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
  public $css = [
    'css/normalize.css',
//      'https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.1.3/dist/css/autoComplete.min.css',
    'css/site.css',
    'css/style.css',
  ];
  public $js = [
      'js/dropzone.js',
      'https://api-maps.yandex.ru/2.1/?apikey=37dcfea9-daf6-4b98-970f-208966a12141&load=package.full&lang=ru-RU',
//        'https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.1.3/dist/autoComplete.min.js',
      'js/messenger.js',
      'js/task.js',
//      'autocomplete.js'
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
  ];

}
