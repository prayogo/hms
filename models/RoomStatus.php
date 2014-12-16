<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomstatus".
 *
 * @property integer $roomstatusid
 * @property string $name
 * @property string $color
 *
 * @property PsRoom[] $psRooms
 * @property PsRoomreservation[] $psRoomreservations 
 */
class RoomStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_roomstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roomstatusid' => 'ID',
            'name' => 'Name',
            'color' => 'Color',
            'colorHtml' => 'Color'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsRooms()
    {
        return $this->hasMany(Room::className(), ['roomstatusid' => 'roomstatusid']);
    }

     /**
    * @return \yii\db\ActiveQuery
    */
    public function getPsRoomreservations()
    {
        return $this->hasMany(RoomReservation::className(), ['roomstatusid' => 'roomstatusid']);
    }

    public function getcolorHtml(){
        return '<span class="label" style="background-color: '.$this->color.';">'.$this->name.'</span>';
    }
}
