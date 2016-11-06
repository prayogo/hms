<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomreservationdetail".
 *
 * @property integer $reservationdetailid
 * @property integer $reservationid
 * @property integer $roomid
 * @property integer $rate
 * @property string $start_date
 * @property string $end_date
 * @property boolean $cancel 
 * @property string $checkin 
 * @property string $checkout 
 * @property integer $roomstatusid 
 *
 * @property PsExtraservice[] $psExtraservices 
 * @property PsReservationpayment[] $psReservationpayments 
 * @property PsRoomreservation $reservation
 * @property PsRoom $room
 * @property PsRoomstatus $roomstatus 
 */
class RoomReservationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_roomreservationdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reservationid', 'roomid', 'rate'], 'required'],
            [['reservationid', 'roomid', 'rate', 'roomstatusid'], 'integer'],
            [['start_date', 'end_date', 'checkin', 'checkout', 'cancel'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reservationdetailid' => 'Reservationdetailid',
            'reservationid' => 'Reservationid',
            'roomid' => 'Roomid',
            'rate' => 'Rate',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'checkin' => 'Check In',
            'checkout' => 'Check Out',
            'cancel' => 'Cancel',
            'roomstatusid'=>'Room Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservation()
    {
        return $this->hasOne(RoomReservation::className(), ['reservationid' => 'reservationid']);
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
    public function getExtraServices() 
    { 
        return $this->hasMany(ExtraService::className(), ['reservationdetailid' => 'reservationdetailid']); 
    } 
 
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getPsReservationpayments() 
    { 
        return $this->hasMany(PsReservationpayment::className(), ['reservationdetailid' => 'reservationdetailid']); 
    }

    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getDiscountreservations() 
    { 
        return $this->hasMany(DiscountReservation::className(), ['reservationdetailid' => 'reservationdetailid']); 
    } 
}
