<?php
/**
 * Created by PhpStorm.
 * User: Mudassar Ali
 * Date: 6/15/2015
 * Time: 9:38 AM
 */

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


class BaseModel extends \yii\db\ActiveRecord
{

    /**
     * Before save pre hook
     * @param $insert
     * @return mixed
     */
    public function beforeSave($insert)
    {
        $session = Yii::$app->session;
        $return = parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->created_by = $session['user_id'];
        }
        return $return;
    }

    /**
     * @return array
     */
    public function behaviors()
    {

        if ($this->hasAttribute(update_at)) {
            $timpstampUpdate = [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'update_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at']
            ];
        } else{
            $timpstampUpdate = [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
            ];
        }
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => $timpstampUpdate,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

}