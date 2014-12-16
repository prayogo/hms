<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_roomtype".
 *
 * @property integer $roomtypeid
 * @property string $name
 * @property integer $singleb
 * @property integer $doubleb
 * @property integer $extrab
 * @property integer $maxchild
 * @property integer $maxadult
 * @property integer $childcharge
 * @property integer $adultcharge
 * @property string $description
 * @property integer $rate
 * @property integer $weekendrate
 *
 * @property PsRoom[] $psRooms
 * @property PsRoomtypeequipment[] $psRoomtypeequipments
 * @property PsEquipment[] $equipment 
 */
class RoomType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_roomtype';
    }

    public $varchildCharge;
    public $varadultCharge;
    public $varrate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','singleb', 'doubleb', 'extrab', 'maxchild', 'maxadult', 'childcharge', 'adultcharge', 'rate', 'weekendrate'], 'required'],
            [['singleb', 'doubleb', 'extrab', 'maxchild', 'maxadult', 'childcharge', 'adultcharge', 'rate', 'weekendrate'], 'integer'],
            [['name'], 'string', 'max' => 50],
            ['name', 'unique'],
            [['description'], 'string', 'max' => 250],
            [['varchildCharge','varadultCharge','varrate'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roomtypeid' => 'ID',
            'name' => 'Name',
            'singleb' => 'Single Bed',
            'doubleb' => 'Double Bed',
            'extrab' => 'Extra Bed',
            'maxchild' => 'Max. Child',
            'maxadult' => 'Max. Adult',
            'childcharge' => 'Child Charge',
            'adultcharge' => 'Adult Charge',
            'description' => 'Description',
            'rate' => 'Rate',
            'weekendrate' => 'Weekend Rate',
            'varchildCharge' => 'Child Charge',
            'varadultCharge' => 'Adult Charge',
            'varrate' => 'Rate',
            'ChildChargeFormat'=>'Child Charge',
            'AdultChargeFormat'=>'Adult Charge',
            'RateChargeFormat'=>'Rate',
            'WeekEndChargeFormat'=>'Weekend Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['roomtypeid' => 'roomtypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomTypeEquipments()
    {
        return $this->hasMany(RoomTypeEquipment::className(), ['roomtypeid' => 'roomtypeid']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEquipment()
    {
        return $this->hasMany(Equipment::className(), ['equipmentid' => 'equipmentid'])->viaTable('ps_roomtypeequipment', 
            ['roomtypeid' =>'roomtypeid']);
    }

    public function getChildChargeFormat(){
        return str_replace(',', '.', number_format($this->childcharge));
    }

    public function getAdultChargeFormat(){
        return str_replace(',', '.', number_format($this->adultcharge));
    }

    public function getRateChargeFormat(){
        return str_replace(',', '.', number_format($this->rate));
    }

    public function getWeekEndChargeFormat(){
        if ($this->weekendrate >= 0)
            return '+' . $this->weekendrate . '%';
        else
            return $this->weekendrate . '%';
    }

    public function getEquipmentText(){
        $roomType = RoomTypeEquipment::find()->where('roomtypeid = :1',[':1'=>$this->roomtypeid,])->all();
        $equipments = [];
        foreach($roomType as $equipment){
            array_push($equipments, $equipment->equipment->name);
        }
        return implode(', ', $equipments);
    }


}
