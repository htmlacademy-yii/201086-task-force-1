<?php


namespace frontend\controllers;


use frontend\services\LocationService;
use GuzzleHttp\Exception\RequestException;
use yii\web\Controller;

class AjaxController extends Controller
{
    public function actionIndex()
    {
        $geocode = 'Ровно';

        $result = LocationService::create($geocode);

        debug($result);
    }

    public function get($geocode, array $params = [])
    {

        try {
            $response = $client->request('GET', 'check', [
              'query' => ['email' => $email, 'access_key' => $api_key]
            ]);

            $content = $response->getBody()->getContents();
            $response_data = json_decode($content, true);

            $result = false;

            if (is_array($response_data)) {
                $result = !empty($response_data['mx_found']) && !empty($response_data['smtp_check']);
            }
        } catch (RequestException $e) {
            $result = true;
        }
    }

}
