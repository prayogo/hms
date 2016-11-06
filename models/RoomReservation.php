<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomreservation".
 *
 * @property integer $reservationid
 * @property integer $customerid
 * @property integer $roomstatusid
 * @property string $date
 *
 * @property PsDiscountreservation[] $psDiscountreservations
 * @property PsExtraservice[] $psExtraservices
 * @property PsCustomer $customer
 * @property PsRoomstatus $roomstatus
 * @property PsRoomreservationdetail[] $psRoomreservationdetails
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
            [['customerid'], 'required'],
            [['customerid'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reservationid' => 'Reservationid',
            'customerid' => 'Customer',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsDiscountreservations()
    {
        return $this->hasMany(PsDiscountreservation::className(), ['reservationid' => 'reservationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsExtraservices()
    {
        return $this->hasMany(PsExtraservice::className(), ['reservationid' => 'reservationid']);
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
    public function getPsRoomreservationdetails()
    {
        return $this->hasMany(PsRoomreservationdetail::className(), ['reservationid' => 'reservationid']);
    }

    public function getReservationdeposits()
    {
        return $this->hasMany(ReservationDeposit::className(), ['reservationid' => 'reservationid']);
    }
}
