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
 * @property string $description
 * @property integer $is_merged
 * @property integer $is_billed
 * @property integer $status
 * @property string $billing_date
 * @property string $challan_date
 * @property string $modified_at
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
            [['challan_number', 'customer_id', 'is_merged', 'is_billed', 'status'], 'integer'],
            [['amount'], 'number'],
            [['billing_date', 'challan_date', 'modified_at'], 'safe'],
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
            'description' => 'Description',
            'is_merged' => 'Is Merged',
            'is_billed' => 'Is Billed',
            'status' => 'Status',
            'billing_date' => 'Billing Date',
            'challan_date' => 'Challan Date',
            'modified_at' => 'Modified At',
        ];
    }
}
