<?php

namespace common\models\query;
use common\models\base\Organization;

/**
 * This is the ActiveQuery class for [[common\models\base\Organization]].
 *
 * @see \common\models\base\Organization
 */
class OrganizationQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Organization[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Organization|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}