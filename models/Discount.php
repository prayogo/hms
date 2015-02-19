<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discount".
 *
 * @property integer $discountid
 * @property integer $roomtypeid
 * @property string $startdate
 * @property string $enddate
 * @property integer $discountrate
 *
 * @property PsRoomtype $roomtype
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomtypeid', 'startdate', 'enddate', 'discountrate'], 'required'],
            [['roomtypeid', 'discountrate'], 'integer'],
            [['startdate', 'enddate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'ID',
            'roomtypeid' => 'Room Type',
            'startdate' => 'Start Date',
            'enddate' => 'End Date',
            'discountrate' => 'Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomtype()
    {
        return $this->hasOne(RoomType::className(), ['roomtypeid' => 'roomtypeid']);
    }
}
