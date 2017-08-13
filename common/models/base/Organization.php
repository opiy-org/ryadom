<?php

namespace common\models\base;

use common\models\query\OrganizationQuery;
use common\models\BaseActiveRecord;
use mootensai\relation\RelationTrait;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "organization".
 *
 * @property integer $id
 * @property string $uuid
 * @property string $title
 * @property string $alias
 * @property string $body
 * @property string $image
 * @property string $inn
 * @property string $kpp
 * @property string $ogrn
 * @property string $email
 * @property string $site
 * @property string $phone
 * @property string $bank_props
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $lock
 *
 * @property \common\models\base\Filial[] $filials
 * @property \common\models\User $createdBy
 * @property \common\models\User $updatedBy
 */
class Organization extends BaseActiveRecord
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
            [['body', 'bank_props'], 'string'],
            [['created_by', 'updated_by', 'status', 'lock'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'title', 'alias', 'email', 'site'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 128],
            [['inn', 'kpp', 'ogrn'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
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
        return 'organization';
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
            'inn' => Yii::t('app', 'Inn'),
            'kpp' => Yii::t('app', 'Kpp'),
            'ogrn' => Yii::t('app', 'Ogrn'),
            'email' => Yii::t('app', 'Email'),
            'site' => Yii::t('app', 'Site'),
            'phone' => Yii::t('app', 'Phone'),
            'bank_props' => Yii::t('app', 'Bank Props'),
            'status' => Yii::t('app', 'Status'),
            'lock' => Yii::t('app', 'Lock'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilials()
    {
        return $this->hasMany(\common\models\base\Filial::className(), ['organization_id' => 'id']);
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
                //'filesStorage' => 'filesystem', // my custom fileStorage from configuration(for properly remove the file from disk)
                'attribute' => 'thumbnail',
                'pathAttribute' => 'image',
                'baseUrlAttribute' => 'image_base_url',

            ],
        ];
    }

    /**
     * @inheritdoc
     * @return OrganizationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }
}
