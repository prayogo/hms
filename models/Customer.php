<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_customer".
 *
 * @property integer $customerid
 * @property string $name
 * @property string $address
 * @property string $locationid
 *
 * @property PsLocation $location
 * @property PsCustomeridentification[] $psCustomeridentifications
 * @property PsCustomerphone[] $psCustomerphones
 * @property PsDiscountcustomer[] $psDiscountcustomers 
 * @property PsRoomreservation[] $psRoomreservations
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_customer';
    }

    public $phone;
    public $varPhone;
    public $varIdentification;

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['name', 'locationid'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 150],
            [['locationid'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerid' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'locationid' => 'Location',
            'phoneText' => 'Phones',
            'identificationText' => 'Identifications',
            'varPhone' => 'Phones',
            'varIdentification' => 'Identifications',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['locationid' => 'locationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomeridentifications()
    {
        return $this->hasMany(CustomerIdentification::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerphones()
    {
        return $this->hasMany(CustomerPhone::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomreservations()
    {
        return $this->hasMany(RoomReservation::className(), ['customerid' => 'customerid']);
    }

    public function getPhoneText(){
        $customerPhone = CustomerPhone::find()->where('customerid = :1',[':1'=>$this->customerid,])->all();
        $phones = [];
        foreach($customerPhone as $phone){
            array_push($phones, $phone->phone);
        }
        return implode('; ', $phones);
    }

    public function getIdentificationText(){
        $arr = CustomerIdentification::find()->where('customerid = :1',[':1'=>$this->customerid,])->all();
        $identifications = [];
        foreach($arr as $data){
            array_push($identifications, $data->identificationtype->name . '(' . $data->identificationno . ')');
        }
        return implode('; ', $identifications);
    }
}
