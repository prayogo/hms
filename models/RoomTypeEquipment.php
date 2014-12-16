<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomtypeequipment".
 *
 * @property integer $roomtypeid
 * @property integer $equipmentid
 *
 * @property PsRoomtype $roomtype
 * @property PsEquipment $equipment
 */
class RoomTypeEquipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_roomtypeequipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomtypeid', 'equipmentid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roomtypeid' => 'Roomtypeid',
            'equipmentid' => 'Equipments',
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
    public function getEquipment()
    {
        return $this->hasOne(Equipment::className(), ['equipmentid' => 'equipmentid']);
    }
}
