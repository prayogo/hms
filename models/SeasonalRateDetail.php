<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_seasonalratedetail".
 *
 * @property integer $seasonalratedetailid
 * @property integer $seasonalrateid
 * @property integer $roomid
 *
 * @property PsSeasonalrate $seasonalrate
 * @property PsRoom $room
 */
class SeasonalRateDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_seasonalratedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seasonalrateid', 'roomid'], 'required'],
            [['seasonalrateid', 'roomid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seasonalratedetailid' => 'Seasonalratedetailid',
            'seasonalrateid' => 'Seasonalrateid',
            'roomid' => 'Roomid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeasonalrate()
    {
        return $this->hasOne(PsSeasonalrate::className(), ['seasonalrateid' => 'seasonalrateid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(PsRoom::className(), ['roomid' => 'roomid']);
    }
}
