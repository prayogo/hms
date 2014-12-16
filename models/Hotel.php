<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_hotel".
 *
 * @property integer $hotelid
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $locationid
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 * @property string $fax
 *
 * @property PsLocation $location
 */
class Hotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'city', 'state', 'locationid', 'email', 'phone1'], 'required', 
                'message'=>'Hotel Information: {attribute} cannot be blank.'],
            [['name', 'city'], 'string', 'max' => 50, 
                'tooLong'=>'Hotel Information: {attribute} should contain at most 50 characters.'],
            [['address', 'state', 'email'], 'string', 'max' => 150, 
                'tooLong'=>'Hotel Information: {attribute} should contain at most 150 characters.'],
            [['locationid'], 'string', 'max' => 3],
            [['phone1', 'phone2', 'fax'], 'string', 'max' => 15,
                'tooLong'=>'Hotel Information: {attribute} should contain at most 15 characters.'],
            ['email', 'email', 'message'=>'Hotel Information: {attribute} is not a valid email address.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hotelid' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'locationid' => 'Location',
            'email' => 'Email',
            'phone1' => 'Phone 1',
            'phone2' => 'Phone 2 (Optional)',
            'fax' => 'Fax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['locationid' => 'locationid']);
    }
}
