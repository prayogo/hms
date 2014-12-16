<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_customer".
 *
 * @property integer $customerid
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $npwp
 * @property string $locationid
 * @property string $birthdate
 * @property string $comment
 * @property string $blacklist
 *
 * @property PsLocation $location
 * @property PsCustomeridentification[] $psCustomeridentifications
 * @property PsCustomerphone[] $psCustomerphones
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
            [['name', 'address', 'locationid', 'birthdate'], 'required'],
            [['birthdate'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['address', 'email'], 'string', 'max' => 150],
            [['npwp'], 'string', 'max' => 25],
            [['locationid'], 'string', 'max' => 3],
            [['comment'], 'string', 'max' => 250],
            [['blacklist'], 'string', 'max' => 1],
            ['email','email'],
            ['birthdate', 'string', 'max'=>12],
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
            'email' => 'Email',
            'npwp' => 'NPWP',
            'locationid' => 'Location',
            'birthdate' => 'Birth Date',
            'comment' => 'Comment',
            'blacklist' => 'Blacklist',
            'blacklistText' => 'Blacklist',
            'phoneText' => 'Phones',
            'identificationText' => 'Identifications',
            'birthdateText' => 'Birth Date',
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

    public function getBlacklistText(){
        if ($this->blacklist == 'Y'){
            return "Yes";
        } else{
            return "No";
        }
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

    public function getBirthdateText(){
        return date("d-M-Y", strtotime($this->birthdate));
    }
}
