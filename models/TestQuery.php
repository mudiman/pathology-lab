<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Test]].
 *
 * @see Test
 */
class TestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Test[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Test|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}