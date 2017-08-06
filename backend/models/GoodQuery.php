<?php

namespace app\models;
use common\models\base\Good;

/**
 * This is the ActiveQuery class for [[common\models\base\Good]].
 *
 * @see \app\models\Good
 */
class GoodQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Good[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Good|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}