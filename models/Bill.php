<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property integer $id
 * @property integer $bill_no
 * @property string $company_name
 * @property string $owner_name
 * @property integer $floor
 * @property string $building
 * @property string $market
 * @property string $city
 * @property string $mobile_number
 * @property string $gst_number
 * @property double $order_total
 * @property double $CGST
 * @property double $IGST
 * @property double $SGST
 * @property double $parcel_packing
 * @property double $extra_charges
 * @property double $discount
 * @property double $net_total
 * @property string $billing_date
 * @property integer $is_paid
 * @property double $received_amount
 * @property integer $status
 * @property string $payment_date
 * @property string $description
 * @property string $created_at
 * @property string $modified_at
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_no', 'floor', 'is_paid', 'status'], 'integer'],
            [['order_total', 'CGST', 'IGST', 'SGST', 'parcel_packing', 'extra_charges', 'discount', 'net_total', 'received_amount'], 'number'],
            [['billing_date', 'payment_date', 'created_at', 'modified_at'], 'safe'],
            [['is_paid'], 'required'],
            [['company_name', 'owner_name', 'building', 'market', 'city', 'mobile_number', 'gst_number'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bill_no' => 'Bill No',
            'company_name' => 'Company Name',
            'owner_name' => 'Owner Name',
            'floor' => 'Floor',
            'building' => 'Building',
            'market' => 'Market',
            'city' => 'City',
            'mobile_number' => 'Mobile Number',
            'gst_number' => 'Gst Number',
            'order_total' => 'Order Total',
            'CGST' => 'CGST',
            'IGST' => 'IGST',
            'SGST' => 'SGST',
            'parcel_packing' => 'Parcel Packing',
            'extra_charges' => 'Extra Charges',
            'discount' => 'Discount',
            'net_total' => 'Net Total',
            'billing_date' => 'Billing Date',
            'is_paid' => 'Is Paid',
            'received_amount' => 'Received Amount',
            'status' => 'Status',
            'payment_date' => 'Payment Date',
            'description' => 'Description',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
}
