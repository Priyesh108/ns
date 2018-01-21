<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "challan_product_mapping".
 *
 * @property integer $cp_id
 * @property integer $challan_number
 * @property integer $group_number
 * @property string $product_name
 * @property double $selling_price
 * @property double $total_units
 * @property double $amount
 *
 * @property Challans $challanNumber
 * @property ProductUnitMapping[] $productUnitMappings
 */
class ChallanProductMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'challan_product_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['challan_number', 'selling_price'], 'required'],
            [['challan_number', 'group_number'], 'integer'],
            [['selling_price', 'total_units', 'amount'], 'number'],
            [['product_name'], 'string', 'max' => 50],
            [['challan_number'], 'exist', 'skipOnError' => true, 'targetClass' => Challans::className(), 'targetAttribute' => ['challan_number' => 'challan_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cp_id' => 'Cp ID',
            'challan_number' => 'Challan Number',
            'group_number' => 'Group Number',
            'product_name' => 'Product Name',
            'selling_price' => 'Selling Price',
            'total_units' => 'Total Units',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChallanNumber()
    {
        return $this->hasOne(Challans::className(), ['challan_number' => 'challan_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUnitMappings()
    {
        return $this->hasMany(ProductUnitMapping::className(), ['cp_id' => 'cp_id']);
    }
}
