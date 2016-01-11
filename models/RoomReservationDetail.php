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
 *
 * @property PsRoomreservation $reservation
 * @property PsRoom $room
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
            [['reservationid', 'roomid', 'rate'], 'integer'],
            [['start_date', 'end_date'], 'safe']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservation()
    {
        return $this->hasOne(PsRoomreservation::className(), ['reservationid' => 'reservationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(PsRoom::className(), ['roomid' => 'roomid']);
    }
}
