<?php
/**
 * Created by PhpStorm.
 * User: opiy
 * Date: 13.03.2017
 * Time: 2:50
 */

namespace common\models;


use kartik\helpers\Html;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;


class BaseActiveRecord extends ActiveRecord
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const VAL_YES = 1;
    const VAL_NO = 0;

    public $_created_at;
    public $_updated_at;


    public static function getStatuses()
    {
        return [
            self::STATUS_DISABLED => Yii::t('backend', 'Disabled'),
            self::STATUS_ENABLED => Yii::t('backend', 'Enabled'),
        ];
    }

    public static function getYNVals()
    {
        return [
            self::VAL_NO => Yii::t('backend', 'No'),
            self::VAL_YES => Yii::t('backend', 'Yes'),
        ];
    }


    public function beforeSave($insert)
    {

        if ($this->hasAttribute('status')) {
            if ((!isset($this->status)) OR ($this->status === NULL)) $this->status = new Expression('default');
        }
        if ($this->hasAttribute('locked')) {
            if ((!isset($this->locked)) OR ($this->locked == NULL)) $this->locked = new Expression('default');
        }

        if ($this->hasAttribute('phone')) {
            if (strlen(trim($this->phone)) > 0) {
                $this->phone = preg_replace('![^\d\+]*!', '', $this->phone);
            }
        }

        return parent::beforeSave($insert);
    }


    public function afterFind()
    {
        parent::afterFind();

        if ($this->hasAttribute('settings')) {
            $test = json_decode($this->settings);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->settings = null;
            }
        }
    }

    public function getBackViewUrl()
    {
        $class = lcfirst(\yii\helpers\StringHelper::basename(get_class($this)));
        return \yii\helpers\Url::toRoute([$class . '/view', 'id' => $this->id]);
    }


    public function getBackViewLnk()
    {
        if ($this->hasAttribute('name')) {
            $name = $this->title;
        } else {
            $name = $this->id;
        }
        return Html::a($name, $this->getBackViewUrl(), ['data-pjax' => "0"]);
    }


    public function generateUniqueRandomString($attribute, $length = 32)
    {

        $randomString = Yii::$app->getSecurity()->generateRandomString($length);

        if (!$this->findOne([$attribute => $randomString]))
            return $randomString;
        else
            return $this->generateUniqueRandomString($attribute, $length);

    }


}