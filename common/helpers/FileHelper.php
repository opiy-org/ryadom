<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 13.08.2017
 * Time: 15:32
 */

namespace common\helpers;


use igogo5yo\uploadfromurl\UploadFromUrl;
use trntv\filekit\File;

class FileHelper
{

    /**
     * @param $url
     * @return bool|string
     */
    public static function uploadFromUrl($url)
    {
        $url = trim($url);
        $path = \Yii::getAlias('@console') . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
        if (!strlen($url) > 3) {
            return false;
        }

        try {
            $file = UploadFromUrl::initWithUrl($url);
            $file->saveAs($path . $file);


            $bucket = \Yii::$app->fileStorage;

            $result = $bucket->save($path . $file);

            if ($result) {
                $result=File::create($result);
            }

            if (file_exists($path . $file)) {
                unlink($path . $file);
            }

        } catch (\Exception $e) {
            return false;
        }

        return $result;
    }

}