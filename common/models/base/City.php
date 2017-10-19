<?php

namespace common\models\base;

use common\models\query\CityQuery;
use common\models\BaseActiveRecord;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

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
 * @property string $flamp
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
class City extends BaseActiveRecord
{
    use RelationTrait;

    public $thumbnail;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['body', 'settings'], 'string'],
            [['map_zoom', 'created_by', 'updated_by', 'status', 'lock'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'title', 'alias'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 128],
            [['flamp'], 'string', 'max' => 255],
            [['map_lat', 'map_lon', 'timezone'], 'string', 'max' => 32],
            [['alias'], 'unique'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator'],
            [['thumbnail'], 'safe'],
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
    public function optimisticLock()
    {
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
            'flamp' => Yii::t('app', 'Flamp'),
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
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
                'immutable'=>true,
                'ensureUnique'=>true,
            ],
            [
                'class' => 'trntv\filekit\behaviors\UploadBehavior',
                'filesStorage' => 'fileStorage', // my custom fileStorage from configuration(for properly remove the file from disk)
                'attribute' => 'thumbnail',
                'pathAttribute' => 'image',
                'baseUrlAttribute' => 'image_base_url',

            ],
        ];
    }

    /**
     * @inheritdoc
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
