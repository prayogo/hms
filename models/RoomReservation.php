<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomreservation".
 *
 * @property integer $roomreservationid
 * @property integer $roomid
 * @property integer $customerid
 * @property string $startdate
 * @property string $enddate
 * @property integer $deposit
 * @property string $cancel
 * @property integer $roomstatusid
 * @property string $out 
 *
 * @property PsExtraservice[] $psExtraservices
 * @property PsRoom $room
 * @property PsCustomer $customer
 * @property PsRoomstatus $roomstatus
 */
class RoomReservation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_roomreservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomid', 'customerid', 'startdate', 'enddate', 'roomstatusid', 'deposit'], 'required'],
            [['roomid', 'customerid', 'roomstatusid'], 'integer'],
            [['startdate', 'enddate', 'out'], 'safe'],
            [['cancel'], 'string', 'max' => 1],
            ['deposit', 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roomreservationid' => 'ID',
            'roomid' => 'Room',
            'customerid' => 'Customer',
            'startdate' => 'Date',
            'enddate' => 'Date',
            'deposit' => 'Deposit',
            'cancel' => 'Cancel',
            'roomstatusid' => 'Status',
            'out' => 'Checking Out',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraservices()
    {
        return $this->hasMany(ExtraService::className(), ['roomreservationid' => 'roomreservationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['roomid' => 'roomid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomstatus()
    {
        return $this->hasOne(RoomStatus::className(), ['roomstatusid' => 'roomstatusid']);
    }

    public function getRoomStatusText(){
        return '<span class="label" style="background-color:'.$this->roomstatus->color.'">'.$this->roomstatus->name.'</span>';
    }
}
