<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $customer_name
 * @property string $product_name
 * @property double $price
 * @property integer $referred_bill_no
 * @property integer $referred_challan_no
 * @property string $created_at
 * @property string $modified_at
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'referred_bill_no', 'referred_challan_no'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['customer_name'], 'string', 'max' => 200],
            [['product_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'customer_name' => 'Customer Name',
            'product_name' => 'Product Name',
            'price' => 'Price',
            'referred_bill_no' => 'Referred Bill No',
            'referred_challan_no' => 'Referred Challan No',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
}
