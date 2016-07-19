<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\validators\EmailValidator;
use \nkovacs\datetimepicker\DateTimePicker;
use yii\db\ActiveRecord;
use app\models\BaseModel;

/**
 * This is the model class for table "report".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $patient_id
 * @property integer $report_template_id
 * @property integer $created_by
 * @property integer $delete
 * @property integer $status
 * @property string $result_at
 * @property string $doctor_ref
 * @property string $remarks
 *
 * @property User $patient
 * @property ReportTemplate $reportTemplate
 * @property User $createdBy
 * @property ReportResult[] $reportResults
 * @property Test[] $tests
 */
class Report extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'result_at'], 'safe'],
            [['patient_id', 'report_template_id'], 'required'],
            [['patient_id', 'report_template_id', 'created_by', 'delete', 'status'], 'integer'],
            [['remarks'], 'string'],
            [['doctor_ref'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'created_at' => 'Created Date time',
            'patient_id' => 'Patient ID',
            'report_template_id' => 'Report Template ID',
            'created_by' => 'Created By',
            'delete' => 'delete',
            'status' => 'Status',
            'result_at' => 'Result Date Time',
            'doctor_ref' => 'Doctor reference',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(User::className(), ['id' => 'patient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportTemplate()
    {
        return $this->hasOne(ReportTemplate::className(), ['id' => 'report_template_id']);
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
    public function getReportResults()
    {
        return $this->hasMany(ReportResult::className(), ['report_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['id' => 'test_id'])->viaTable('report_result', ['report_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportQuery(get_called_class());
    }
}
