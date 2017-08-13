<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 25.06.2017
 * Time: 1:31
 */

namespace common\helpers;


use Closure;
use Yii;
use yii\caching\Dependency;

class CacheHelper
{

    public static function doit($cacheId, Closure $query, Dependency $dependency = null, $cacheTime = null)
    {
        $cacheTime = ($cacheTime === null) ? Yii::$app->params['cache_time'] : $cacheTime;
        $data      = Yii::$app->cache->get($cacheId);

        if ($data === false) {
            $data = $query();
            Yii::$app->cache->set($cacheId, $data, $cacheTime, $dependency);
        }

        return $data;
    }

}