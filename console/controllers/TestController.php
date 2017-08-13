<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 13.08.2017
 * Time: 8:25
 */

namespace console\controllers;

use igogo5yo\uploadfromurl\UploadFromUrl;
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
     */
    public function actionIndex()
    {

        $path=Yii::getAlias('@console') . DIRECTORY_SEPARATOR .  'tmp' . DIRECTORY_SEPARATOR;

        $url = 'https://cdn.flamp.ru/4ce917d61bb2688bf8aca575f40d36ba_320.jpg';
        $file = UploadFromUrl::initWithUrl($url);
        $file->saveAs($path . $file);


        $bucket = Yii::$app->fileStorage;
        $res=$bucket->save($path.$file);
        print_r($res);

    }
}