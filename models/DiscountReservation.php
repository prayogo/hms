<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discountreservation".
 *
 * @property integer $discountid
 * @property integer $reservationdetailid
 * @property integer $rate
 *
 * @property PsRoomreservationdetail $reservationdetail
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
            [['discountid', 'reservationdetailid', 'rate'], 'required'],
            [['discountid', 'reservationdetailid', 'rate'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'reservationdetailid' => 'Reservationdetailid',
            'rate' => 'Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservationdetail()
    {
        return $this->hasOne(PsRoomreservationdetail::className(), ['reservationdetailid' => 'reservationdetailid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['discountid' => 'discountid']);
    }
}
