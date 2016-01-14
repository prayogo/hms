<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discountroomtype".
 *
 * @property integer $discountid
 * @property integer $roomtypeid
 *
 * @property PsRoomtype $roomtype
 */
class DiscountRoomType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_discountroomtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discountid', 'roomtypeid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discounts',
            'roomtypeid' => 'Roomtypeid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomtype()
    {
        return $this->hasOne(RoomType::className(), ['roomtypeid' => 'roomtypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['discountid' => 'discountid']);
    }
}
