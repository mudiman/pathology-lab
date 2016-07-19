<?php

namespace app\models;

use Yii;
use app\models\BaseModel;
use yii\validators\ExistValidator;

/**
 * This is the model class for table "report_result".
 *
 * @property integer $report_id
 * @property integer $test_id
 * @property double $result
 * @property string $created_at
 * @property integer $delete
 * @property integer $created_by
 *
 * @property Report $report
 * @property Test $test
 * @property User $createdBy
 */
class ReportResult extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id', 'test_id', 'result'], 'required'],
            [['test_id'], 'unique', 'targetAttribute' => ['report_id','test_id']],
            [['report_id', 'test_id', 'delete'], 'integer'],
            [['result'], 'number'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Report ID',
            'test_id' => 'Test ID',
            'result' => 'Result',
            'created_at' => 'Create At',
            'delete' => 'Delete',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::className(), ['id' => 'report_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @inheritdoc
     * @return ReportResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportResultQuery(get_called_class());
    }
}
