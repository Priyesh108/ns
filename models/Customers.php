<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property integer $customer_id
 * @property string $name
 * @property string $owner
 * @property integer $floor
 * @property string $building
 * @property string $market
 * @property string $city
 * @property string $office_phone
 * @property string $mobile_1
 * @property string $mobile_2
 * @property string $gst_number
 * @property string $comments
 * @property string $created_at
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'owner', 'city', 'mobile_1', 'gst_number'], 'required'],
            [['floor'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'owner', 'building', 'market', 'city'], 'string', 'max' => 50],
            [['office_phone', 'mobile_1', 'mobile_2'], 'string', 'max' => 15],
            [['gst_number'], 'string', 'max' => 20],
            [['comments'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'owner' => 'Owner',
            'floor' => 'Floor',
            'building' => 'Building',
            'market' => 'Market',
            'city' => 'City',
            'office_phone' => 'Office Phone',
            'mobile_1' => 'Mobile 1',
            'mobile_2' => 'Mobile 2',
            'gst_number' => 'GST Number',
            'comments' => 'Comments',
            'created_at' => 'Created At',
        ];
    }
}
