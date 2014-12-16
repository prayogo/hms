<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_floor".
 *
 * @property integer $floorid
 * @property string $name
 *
 * @property PsRoom[] $psRooms
 */
class Floor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_floor';
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
            'floorid' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsRooms()
    {
        return $this->hasMany(Room::className(), ['floorid' => 'floorid']);
    }
}
