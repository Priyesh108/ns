<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "challan_product_mapping".
 *
 * @property integer $cp_id
 * @property integer $challan_number
 * @property integer $product_id
 * @property double $base_unit
 * @property double $mutiplier_unit
 * @property integer $group_id
 * @property double $selling_price
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
            [['challan_number', 'product_id', 'base_unit', 'mutiplier_unit', 'group_id', 'selling_price'], 'required'],
            [['challan_number', 'product_id', 'group_id'], 'integer'],
            [['base_unit', 'mutiplier_unit', 'selling_price'], 'number'],
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
            'product_id' => 'Product',
            'base_unit' => 'Base Unit',
            'mutiplier_unit' => 'Mutiplier Unit',
            'group_id' => 'Group ID',
            'selling_price' => 'Selling Price',
        ];
    }
}
