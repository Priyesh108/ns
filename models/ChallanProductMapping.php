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
 *
 * @property ProductUnitMaaping[] $productUnitMaapings
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
            [['selling_price'], 'number'],
            [['product_name'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUnitMaapings()
    {
        return $this->hasMany(ProductUnitMaaping::className(), ['cp_id' => 'cp_id']);
    }
}
