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
            [['discountid', 'roomtypeid'], 'required'],
            [['discountid', 'roomtypeid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'roomtypeid' => 'Roomtypeid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomtype()
    {
        return $this->hasOne(PsRoomtype::className(), ['roomtypeid' => 'roomtypeid']);
    }
}
