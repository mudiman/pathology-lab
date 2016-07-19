<?php

namespace app\models;

use Yii;
use app\models\BaseModel;

/**
 * This is the model class for table "report_template".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 *
 * @property Report[] $reports
 * @property User $createdBy
 * @property Test[] $tests
 */
class ReportTemplate extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Report Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['report_template_id' => 'id']);
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
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['report_template_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ReportTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportTemplateQuery(get_called_class());
    }
}
