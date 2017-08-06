<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "city".
 *
 * @property integer $id
 * @property string $uuid
 * @property string $title
 * @property string $alias
 * @property string $body
 * @property string $image
 * @property string $map_lat
 * @property string $map_lon
 * @property integer $map_zoom
 * @property string $timezone
 * @property string $settings
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $lock
 *
 * @property \common\models\User $createdBy
 * @property \common\models\User $updatedBy
 * @property \common\models\base\Filial[] $filials
 */
class City extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['body', 'settings'], 'string'],
            [['map_zoom', 'created_by', 'updated_by', 'status', 'lock'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'title', 'alias'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 128],
            [['map_lat', 'map_lon', 'timezone'], 'string', 'max' => 32],
            [['alias'], 'unique'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uuid' => Yii::t('app', 'Uuid'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'body' => Yii::t('app', 'Body'),
            'image' => Yii::t('app', 'Image'),
            'map_lat' => Yii::t('app', 'Map Lat'),
            'map_lon' => Yii::t('app', 'Map Lon'),
            'map_zoom' => Yii::t('app', 'Map Zoom'),
            'timezone' => Yii::t('app', 'Timezone'),
            'settings' => Yii::t('app', 'Settings'),
            'status' => Yii::t('app', 'Status'),
            'lock' => Yii::t('app', 'Lock'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'updated_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilials()
    {
        return $this->hasMany(\common\models\base\Filial::className(), ['city_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'uuid',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\CityQuery(get_called_class());
    }
}
