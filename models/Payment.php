<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_payment".
 *
 * @property integer $paymentid
 * @property integer $customerid
 * @property string $date
 * @property integer $amountpaid
 *
 * @property PsCustomer $customer
 * @property PsReservationpayment[] $psReservationpayments
 * @property PsRoomreservation[] $roomreservations
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerid', 'date'], 'required'],
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
            'paymentid' => 'ID',
            'customerid' => 'Customer',
            'date' => 'Date'
        ];
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
    public function getReservationpayments()
    {
        return $this->hasMany(ReservationPayment::className(), ['paymentid' => 'paymentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomreservations()
    {
        return $this->hasMany(RoomReservation::className(), ['roomreservationid' => 'roomreservationid'])->viaTable('ps_reservationpayment', ['paymentid' => 'paymentid']);
    }

    public function getDateText(){
        return date('d-M-Y', strtotime($this->date));
    }

    public function getNumberFormat(){
        return \app\models\Tax::find()->orderBy('taxid desc')->one()->currency . ' ' . number_format($this->amountpaid);
    }
}
