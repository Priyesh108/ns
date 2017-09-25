<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Challans;

/**
 * ChallansSearch represents the model behind the search form about `app\models\Challans`.
 */
class ChallansSearch extends Challans
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_id', 'challan_number', 'customer_id', 'is_merged', 'is_billed'], 'integer'],
            [['amount'], 'number'],
            [['challan_date', 'description', 'billing_date'], 'safe'],
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
        $query = Challans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'c_id' => $this->c_id,
            'challan_number' => $this->challan_number,
            'customer_id' => $this->customer_id,
            'amount' => $this->amount,
            'challan_date' => $this->challan_date,
            'is_merged' => $this->is_merged,
            'is_billed' => $this->is_billed,
            'billing_date' => $this->billing_date,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
