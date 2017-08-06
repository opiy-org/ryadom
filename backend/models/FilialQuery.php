<?php

namespace app\models;
use common\models\base\Filial;

/**
 * This is the ActiveQuery class for [[common\models\base\Filial]].
 *
 * @see \app\models\Filial
 */
class FilialQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Filial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Filial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}