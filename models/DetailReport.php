<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail_report".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $user_id
 * @property string $report_name
 * @property string $file_name
 * @property integer $delete
 * @property integer $status
 * @property string $result_at
 * @property string $doctor ref
 * @property string $remarks
 * @property string $name
 * @property string $type
 * @property string $unit
 * @property string $reference
 * @property double $result
 */
class DetailReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detail_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'delete', 'status'], 'integer'],
            [['created_at', 'result_at'], 'safe'],
            [['user_id'], 'required'],
            [['remarks', 'reference'], 'string'],
            [['result'], 'number'],
            [['report_name', 'file_name', 'unit'], 'string', 'max' => 45],
            [['doctor ref', 'name', 'type'], 'string', 'max' => 100]
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
            'user_id' => 'User ID',
            'report_name' => 'Report Name',
            'file_name' => 'Report File Name',
            'delete' => 'delete',
            'status' => 'Status',
            'result_at' => 'Result Date Time',
            'doctor ref' => 'Doctor reference',
            'remarks' => 'Remarks',
            'name' => 'Test Name',
            'type' => 'Test type',
            'unit' => 'Unit',
            'reference' => 'Reference Range',
            'result' => 'Result',
        ];
    }

    /**
     * @inheritdoc
     * @return DetailReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DetailReportQuery(get_called_class());
    }
}
