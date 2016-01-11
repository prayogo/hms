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
            [['customerid', 'roomstatusid'], 'required'],
            [['customerid', 'roomstatusid'], 'integer'],
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
            'customerid' => 'Customerid',
            'roomstatusid' => 'Roomstatusid',
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
        return $this->hasOne(PsCustomer::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomstatus()
    {
        return $this->hasOne(PsRoomstatus::className(), ['roomstatusid' => 'roomstatusid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsRoomreservationdetails()
    {
        return $this->hasMany(PsRoomreservationdetail::className(), ['reservationid' => 'reservationid']);
    }
}
