<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_extraservice".
 *
 * @property integer $extraserviceid
 * @property integer $serviceitemid
 * @property integer $roomreservationid
 * @property integer $quantity
 * @property string $date 
 *
 * @property PsServiceitem $serviceitem
 * @property PsRoomreservation $roomreservation
 */
class ExtraService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_extraservice';
    }

    public $time;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serviceitemid', 'roomreservationid', 'quantity', 'date', 'time'], 'required'],
            [['serviceitemid', 'roomreservationid', 'quantity'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'extraserviceid' => 'ID',
            'serviceitemid' => 'Item',
            'roomreservationid' => 'Room Reservation',
            'quantity' => 'Quantity',
            'date' => 'Date', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceitem()
    {
        return $this->hasOne(ServiceItem::className(), ['serviceitemid' => 'serviceitemid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomreservation()
    {
        return $this->hasOne(RoomReservation::className(), ['roomreservationid' => 'roomreservationid']);
    }
}
