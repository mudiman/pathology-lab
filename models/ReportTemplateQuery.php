<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ReportTemplate]].
 *
 * @see ReportTemplate
 */
class ReportTemplateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ReportTemplate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ReportTemplate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}