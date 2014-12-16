<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_equipment".
 *
 * @property integer $equipmentid
 * @property string $name
 *
 * @property PsRoomtypeequipment[] $psRoomtypeequipments
 * @property PsRoomtype[] $roomtypes 
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_equipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equipmentid' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomTypeEquipments()
    {
        return $this->hasMany(RoomTypeEquipment::className(), ['equipmentid' => 'equipmentid']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRoomtypes()
    {
        return $this->hasMany(RoomType::className(), ['roomtypeid' => 'roomtypeid'])->viaTable('ps_roomtypeequipment', ['equipmentid' => 'equipmentid']);
    }
}
