<?php
namespace common\helpers;

use common\helpers\CacheHelper;

/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 22.01.2016
 * Time: 0:47
 */
class YmapsHelper
{

    public static function getCoords($addr)
    {
        return CacheHelper::doit('ymaps_' . $addr,
            function () use ($addr) {
                try {
                    $url = 'https://geocode-maps.yandex.ru/1.x/?format=json&geocode=' . $addr;
                    $res = json_decode(file_get_contents($url));
                    $coords = $res->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
                    $coords = explode(' ', $coords);
                } catch (\Exception $e) {
                    return false;
                }
                return [
                    'lat' => $coords[1],
                    'lon' => $coords[0],
                ];
            },
            null, 3600);
    }

}