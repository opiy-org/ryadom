<?php

namespace common\models\base;

use common\models\query\ReviewQuery;
use common\models\BaseActiveRecord;
use mootensai\relation\RelationTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "review".
 *
 * @property integer $id
 * @property string $uuid
 * @property integer $filial_id
 * @property string $user_name
 * @property string $title
 * @property string $body
 * @property string $image
 * @property integer $rating
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
class Review extends BaseActiveRecord
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
            [['filial_id', 'rating', 'created_by', 'updated_by', 'lock'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'title'], 'string', 'max' => 64],
            [['user_name', 'image'], 'string', 'max' => 128],
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
        return 'review';
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
            'user_name' => Yii::t('app', 'User Name'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'image' => Yii::t('app', 'Image'),
            'rating' => Yii::t('app', 'Rating'),
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
     * @return ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewQuery(get_called_class());
    }
}
