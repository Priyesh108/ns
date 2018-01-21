<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_challan_mapping".
 *
 * @property integer $id
 * @property integer $bill_no
 * @property integer $challan_number
 * @property string $created_at
 * @property string $modified_at
 */
class BillChallanMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_challan_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_no', 'challan_number'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
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
            'challan_number' => 'Challan Number',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
}
