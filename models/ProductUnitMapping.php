<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_unit_mapping".
 *
 * @property integer $pu_id
 * @property integer $cp_id
 * @property double $base_unit
 * @property double $multiplier_unit
 * @property double $total_units
 *
 * @property ChallanProductMapping $cp
 */
class ProductUnitMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_unit_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cp_id'], 'required'],
            [['cp_id'], 'integer'],
            [['base_unit', 'multiplier_unit', 'total_units'], 'number'],
            [['cp_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChallanProductMapping::className(), 'targetAttribute' => ['cp_id' => 'cp_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pu_id' => 'Pu ID',
            'cp_id' => 'Cp ID',
            'base_unit' => 'Base Unit',
            'multiplier_unit' => 'Multiplier Unit',
            'total_units' => 'Total Units',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCp()
    {
        return $this->hasOne(ChallanProductMapping::className(), ['cp_id' => 'cp_id']);
    }
}
