<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "challans".
 *
 * @property integer $c_id
 * @property integer $challan_number
 * @property integer $customer_id
 * @property double $amount
 * @property string $challan_date
 * @property string $description
 * @property integer $is_merged
 * @property integer $is_billed
 * @property string $billing_date
 */
class Challans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'challans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['challan_number', 'customer_id'], 'required'],
            [['challan_number', 'customer_id', 'is_merged', 'is_billed'], 'integer'],
            [['amount'], 'number'],
            [['challan_date', 'billing_date'], 'safe'],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'c_id' => 'C ID',
            'challan_number' => 'Challan Number',
            'customer_id' => 'Customer',
            'amount' => 'Amount',
            'challan_date' => 'Challan Date',
            'description' => 'Description',
            'is_merged' => 'Is Merged',
            'is_billed' => 'Is Billed',
            'billing_date' => 'Billing Date',
        ];
    }
}
