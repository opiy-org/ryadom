<?php

namespace app\models;
use common\models\base\City;

/**
 * This is the ActiveQuery class for [[common\models\base\City]].
 *
 * @see \common\models\base\City
 */
class CityQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return City[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return City|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}