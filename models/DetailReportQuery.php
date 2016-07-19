<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DetailReport]].
 *
 * @see DetailReport
 */
class DetailReportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return DetailReport[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DetailReport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}