<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 13.08.2017
 * Time: 15:32
 */

namespace common\helpers;


use igogo5yo\uploadfromurl\UploadFromUrl;

class FileHelper
{

    public static function uploadFroomUrl($url)
    {
        $url = trim($url);
        $path = \Yii::getAlias('@console') . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
        if (!strlen($url) > 3) return null;

        try {
            $file = UploadFromUrl::initWithUrl($url);
            $file->saveAs($path . $file);


            $bucket = \Yii::$app->fileStorage;

            $result = $bucket->save($path . $file);

            if (file_exists($path . $file)) {
                unlink($path . $file);
            }
            return $result;
        } catch (\Exception $e) {
            return null;
        }
    }

}