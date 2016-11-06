<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_extraservice".
 *
 * @property integer $extraserviceid
 * @property integer $reservationdetailid
 * @property string $date
 *
 * @property PsRoomreservationdetail $reservationdetail
 * @property PsExtraservicedetail[] $psExtraservicedetails
 */
class ExtraService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_extraservice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reservationdetailid'], 'required'],
            [['reservationdetailid'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'extraserviceid' => 'Extraserviceid',
            'reservationdetailid' => 'Reservationdetailid',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservationdetail()
    {
        return $this->hasOne(PsRoomreservationdetail::className(), ['reservationdetailid' => 'reservationdetailid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraservicedetails()
    {
        return $this->hasMany(ExtraServiceDetail::className(), ['extraserviceid' => 'extraserviceid']);
    }
}
