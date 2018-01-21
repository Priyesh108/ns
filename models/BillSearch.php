<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bill;

/**
 * BillSearch represents the model behind the search form about `app\models\Bill`.
 */
class BillSearch extends Bill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bill_no', 'floor', 'is_paid'], 'integer'],
            [['company_name', 'owner_name', 'building', 'market', 'city', 'mobile_number', 'gst_number', 'billing_date', 'payment_date', 'description', 'created_at', 'modified_at'], 'safe'],
            [['order_total', 'CGST', 'IGST', 'SGST', 'parcel_packing', 'extra_charges', 'discount', 'net_total', 'received_amount'], 'number'],
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
        $query = Bill::find();

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
            'id' => $this->id,
            'bill_no' => $this->bill_no,
            'floor' => $this->floor,
            'order_total' => $this->order_total,
            'CGST' => $this->CGST,
            'IGST' => $this->IGST,
            'SGST' => $this->SGST,
            'parcel_packing' => $this->parcel_packing,
            'extra_charges' => $this->extra_charges,
            'discount' => $this->discount,
            'net_total' => $this->net_total,
            'billing_date' => $this->billing_date,
            'is_paid' => $this->is_paid,
            'received_amount' => $this->received_amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'market', $this->market])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'gst_number', $this->gst_number])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
