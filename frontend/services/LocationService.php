<?php


namespace frontend\services;


use frontend\models\Locations;

class LocationService
{
    public static function create($location)
    {
        $arrayLocation = explode(' ', YandexService::geoocode($location));

        $city = Locations::create($location, $arrayLocation[0], $arrayLocation[1]);
        return $city->id;
    }

}
