<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_reservationdeposit".
 *
 * @property integer $depositid
 * @property string $date
 * @property integer $reservationid
 * @property integer $rate
 *
 * @property PsRoomreservation $reservation
 */
class ReservationDeposit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_reservationdeposit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'reservationid', 'rate'], 'required'],
            [['date', 'returndate'], 'safe'],
            [['reservationid', 'rate'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'depositid' => 'Depositid',
            'date' => 'Date',
            'reservationid' => 'Reservationid',
            'rate' => 'Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservation()
    {
        return $this->hasOne(PsRoomreservation::className(), ['reservationid' => 'reservationid']);
    }
}
