<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 13.08.2017
 * Time: 8:25
 */

namespace console\controllers;

use common\helpers\FileHelper;
use common\models\base\Filial;
use trntv\filekit\File;
use Yii;
use yii\console\Controller;


/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends Controller
{


    /**
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {

        $path = Yii::getAlias('@console') . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

        $url = 'https://cdn.flamp.ru/4ce917d61bb2688bf8aca575f40d36ba_320.jpg';

        $z = new Filial();

        $z->title = 'test';
        $z->organization_id = 1;
        $z->city_id = 1;
        $z->thumbnail = FileHelper::uploadFromUrl($url);
        if (!$z->save()) {
            print_r($z->getErrors());
        } else {
            print_r($z->attributes);
        }


    }
}