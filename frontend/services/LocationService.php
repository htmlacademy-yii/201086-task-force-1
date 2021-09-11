<?php


namespace frontend\services;


use frontend\models\Locations;

class LocationService
{
    public static function create($location)
    {
        $arrayLocation = explode(' ', YandexService::geoocode($location));
        $model = Locations::find()->where(['lat' => $arrayLocation[0]])->all();
        if ($model !== null) {
            foreach ($model as $el) {
                if ($el->long == $arrayLocation[1]) {
                    return $el->id;
                }
            }
        }
        $city = Locations::create($location, $arrayLocation[0], $arrayLocation[1]);
        return $city->id;
    }

}
