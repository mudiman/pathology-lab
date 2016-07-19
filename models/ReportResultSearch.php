<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportResult;

/**
 * ReportResultSearch represents the model behind the search form about `app\models\ReportResult`.
 */
class ReportResultSearch extends ReportResult
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id', 'test_id', 'delete', 'created_by'], 'integer'],
            [['result'], 'number'],
            [['created_at'], 'safe'],
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
        $query = ReportResult::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'report_id' => $this->report_id,
            'test_id' => $this->test_id,
            'result' => $this->result,
            'created_at' => $this->created_at,
            'delete' => $this->delete,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }
}
