<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customers;

/**
 * CustomersSearch represents the model behind the search form about `app\models\Customers`.
 */
class CustomersSearch extends Customers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'floor'], 'integer'],
            [['name', 'owner', 'building', 'market', 'city', 'office_phone', 'mobile_1', 'mobile_2', 'gst_number', 'comments', 'created_at'], 'safe'],
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
        $query = Customers::find();

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
            'customer_id' => $this->customer_id,
            'floor' => $this->floor,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'market', $this->market])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'office_phone', $this->office_phone])
            ->andFilterWhere(['like', 'mobile_1', $this->mobile_1])
            ->andFilterWhere(['like', 'mobile_2', $this->mobile_2])
            ->andFilterWhere(['like', 'gst_number', $this->gst_number])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
