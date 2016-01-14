<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discountroom".
 *
 * @property integer $discountid
 * @property integer $roomid
 *
 * @property PsRoom $room
 */
class DiscountRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_discountroom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discountid', 'roomid'], 'required'],
            [['discountid', 'roomid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'roomid' => 'Roomid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['roomid' => 'roomid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['discountid' => 'discountid']);
    }
}
