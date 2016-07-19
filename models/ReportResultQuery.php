<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ReportResult]].
 *
 * @see ReportResult
 */
class ReportResultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ReportResult[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ReportResult|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}