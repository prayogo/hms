<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_reservationpayment".
 *
 * @property integer $paymentid
 * @property integer $roomreservationid
 *
 * @property PsPayment $payment
 * @property PsRoomreservation $roomreservation
 */
class ReservationPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_reservationpayment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paymentid', 'reservationdetailid'], 'required'],
            [['paymentid', 'reservationdetailid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paymentid' => 'Paymentid',
            'reservationdetailid' => 'Reservationdetailid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(PsPayment::className(), ['paymentid' => 'paymentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomreservationdetail()
    {
        return $this->hasOne(RoomReservationDetail::className(), ['reservationdetailid' => 'reservationdetailid']);
    }
}
