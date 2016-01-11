<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discountreservation".
 *
 * @property integer $discountid
 * @property integer $reservationid
 *
 * @property PsRoomreservation $reservation
 */
class DiscountReservation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_discountreservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discountid', 'reservationid'], 'required'],
            [['discountid', 'reservationid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'reservationid' => 'Reservationid',
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
