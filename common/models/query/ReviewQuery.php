<?php

namespace common\models\query;
use common\models\base\Review;

/**
 * This is the ActiveQuery class for [[common\models\base\Review]].
 *
 * @see \common\models\base\Review
 */
class ReviewQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Review[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Review|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}