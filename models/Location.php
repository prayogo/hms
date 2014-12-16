<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_location".
 *
 * @property string $locationid
 * @property string $iso2
 * @property string $name
 *
 * @property PsCustomer[] $psCustomers
 * @property PsHotel[] $psHotels
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locationid', 'name'], 'required'],
            [['locationid'], 'string', 'max' => 3],
            [['iso2'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'locationid' => 'ISO 3',
            'iso2' => 'ISO 2',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['locationid' => 'locationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotels()
    {
        return $this->hasMany(Hotel::className(), ['locationid' => 'locationid']);
    }
}
