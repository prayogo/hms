<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomreservationrate".
 *
 * @property integer $roomreservationid
 * @property integer $rate
 * @property integer $childcharge
 * @property integer $adultcharge
 * @property integer $weekendrate
 */
class RoomReservationRate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_roomreservationrate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomreservationid'], 'required'],
            [['roomreservationid', 'rate', 'childcharge', 'adultcharge', 'weekendrate'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roomreservationid' => 'Roomreservationid',
            'rate' => 'Rate',
            'childcharge' => 'Childcharge',
            'adultcharge' => 'Adultcharge',
            'weekendrate' => 'Weekendrate',
        ];
    }
}
