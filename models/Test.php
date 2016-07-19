<?php

namespace app\models;

use Yii;
use app\models\BaseModel;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $name
 * @property integer $report_template_id
 * @property string $created_at
 * @property integer $delete
 * @property string $update_at
 * @property integer $created_by
 * @property string $unit
 * @property string $reference
 * @property string $remark
 *
 * @property ReportResult[] $reportResults
 * @property Report[] $reports
 * @property User $createdBy
 * @property ReportTemplate $reportTemplate
 */
class Test extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_template_id'], 'required'],
            [['report_template_id', 'delete'], 'integer'],
            [['created_at'], 'safe'],
            [['reference', 'remark'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['update_at', 'unit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Test Id',
            'name' => 'Test Name',
            'report_template_id' => 'Report Template ID',
            'created_at' => 'Added date time',
            'delete' => 'Delete',
            'update_at' => 'Update At',
            'created_by' => 'Create by',
            'unit' => 'Unit',
            'reference' => 'Reference Range',
            'remark' => 'Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportResults()
    {
        return $this->hasMany(ReportResult::className(), ['test_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['id' => 'report_id'])->viaTable('report_result', ['test_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportTemplate()
    {
        return $this->hasOne(ReportTemplate::className(), ['id' => 'report_template_id']);
    }

    /**
     * @inheritdoc
     * @return TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestQuery(get_called_class());
    }
}
