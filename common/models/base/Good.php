<?php

namespace common\models\base;

use common\models\query\GoodQuery;
use common\models\BaseActiveRecord;
use mootensai\relation\RelationTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "good".
 *
 * @property integer $id
 * @property string $uuid
 * @property integer $filial_id
 * @property string $title
 * @property string $body
 * @property string $image
 * @property string $qnt
 * @property string $price
 * @property string $settings
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $lock
 *
 * @property \common\models\User $createdBy
 * @property \common\models\base\Filial $filial
 * @property \common\models\User $updatedBy
 */
class Good extends BaseActiveRecord
{
    use RelationTrait;

    public $thumbnail;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filial_id', 'title'], 'required'],
            [['filial_id', 'qnt', 'created_by', 'updated_by', 'lock'], 'integer'],
            [['body','settings'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'title'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 128],
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
        return 'good';
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
            'filial_id' => Yii::t('app', 'Filial ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'image' => Yii::t('app', 'Image'),
            'qnt' => Yii::t('app', 'Qnt'),
            'price' => Yii::t('app', 'Price'),
            'settings' => Yii::t('app', 'Settings'),
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
    public function getFilial()
    {
        return $this->hasOne(\common\models\base\Filial::className(), ['id' => 'filial_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'updated_by']);
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
        ];
    }

    /**
     * @inheritdoc
     * @return GoodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GoodQuery(get_called_class());
    }
}
