<?php

namespace common\models\base;

use common\models\BaseActiveRecord;
use common\models\query\FilialQuery;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "filial".
 *
 * @property integer $id
 * @property string $uuid
 * @property integer $organization_id
 * @property integer $city_id
 * @property string $title
 * @property string $alias
 * @property string $body
 * @property string $image
 * @property string $street
 * @property string $bld
 * @property string $addr_extra
 * @property string $map_lat
 * @property string $map_lon
 * @property integer $map_zoom
 * @property string $email
 * @property string $site
 * @property string $flamp
 * @property string $phone
 * @property string $settings
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $lock
 *
 * @property \common\models\base\City $city
 * @property \common\models\User $createdBy
 * @property \common\models\base\Organization $organization
 * @property \common\models\User $updatedBy
 * @property \common\models\base\Good[] $goods
 * @property \common\models\base\Review[] $reviews
 */
class Filial extends BaseActiveRecord
{
    use RelationTrait;

    public $thumbnail;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'city_id', 'map_zoom', 'created_by', 'updated_by', 'status', 'lock'], 'integer'],
            [['title'], 'required'],
            [['body', 'settings'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'title', 'alias', 'email', 'site', 'street', 'addr_extra'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 128],
            [['flamp'], 'string', 'max' => 255],
            [['map_lat', 'map_lon'], 'string', 'max' => 32],
            [['phone', 'bld'], 'string', 'max' => 16],
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
        return 'filial';
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
            'organization_id' => Yii::t('app', 'Organization ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'body' => Yii::t('app', 'Body'),
            'image' => Yii::t('app', 'Image'),
            'street' => Yii::t('app', 'Street'),
            'bld' => Yii::t('app', 'Bld'),
            'addr_extra' => Yii::t('app', 'Addr_extra'),
            'map_lat' => Yii::t('app', 'Map Lat'),
            'map_lon' => Yii::t('app', 'Map Lon'),
            'map_zoom' => Yii::t('app', 'Map Zoom'),
            'email' => Yii::t('app', 'Email'),
            'site' => Yii::t('app', 'Site'),
            'flamp' => Yii::t('app', 'Flamp'),
            'phone' => Yii::t('app', 'Phone'),
            'settings' => Yii::t('app', 'Settings'),
            'status' => Yii::t('app', 'Status'),
            'lock' => Yii::t('app', 'Lock'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(\common\models\base\City::className(), ['id' => 'city_id']);
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
    public function getOrganization()
    {
        return $this->hasOne(\common\models\base\Organization::className(), ['id' => 'organization_id']);
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
    public function getGoods()
    {
        return $this->hasMany(\common\models\base\Good::className(), ['filial_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(\common\models\base\Review::className(), ['filial_id' => 'id']);
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
                'class' => 'trntv\filekit\behaviors\UploadBehavior',
                'filesStorage' => 'fileStorage', // my custom fileStorage from configuration(for properly remove the file from disk)
                'attribute' => 'thumbnail',
                'pathAttribute' => 'image',
                'baseUrlAttribute' => 'image_base_url',

            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return FilialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FilialQuery(get_called_class());
    }


}
