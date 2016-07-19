<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Report;

/**
 * ReportSearch represents the model behind the search form about `app\models\Report`.
 */
class ReportSearch extends Report
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'patient_id', 'report_template_id', 'created_by', 'delete', 'status'], 'integer'],
            [['created_at', 'result_at', 'doctor_ref', 'remarks'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Report::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['created_at']],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $session = Yii::$app->session;
        if ($session['type'] != 'user') {
            $query->andFilterWhere([
                'patient_id'=> $session['user_id'],
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'patient_id' => $this->patient_id,
            'report_template_id' => $this->report_template_id,
            'created_by' => $this->created_by,
            'delete' => $this->delete,
            'status' => $this->status,
            'result_at' => $this->result_at,
        ]);

        $query->andFilterWhere(['like', 'doctor_ref', $this->doctor_ref])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
