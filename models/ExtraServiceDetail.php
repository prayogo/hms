<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_extraservicedetail".
 *
 * @property integer $extraservicedetailid
 * @property integer $extraserviceid
 * @property integer $serviceitemid
 * @property integer $rate
 * @property integer $quantity
 *
 * @property PsExtraservice $extraservice
 * @property PsServiceitem $serviceitem
 */
class ExtraServiceDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_extraservicedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extraserviceid', 'serviceitemid', 'rate', 'quantity'], 'required'],
            [['extraserviceid', 'serviceitemid', 'rate', 'quantity'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'extraservicedetailid' => 'Extraservicedetailid',
            'extraserviceid' => 'Extraserviceid',
            'serviceitemid' => 'Serviceitemid',
            'rate' => 'Rate',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraservice()
    {
        return $this->hasOne(PsExtraservice::className(), ['extraserviceid' => 'extraserviceid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceitem()
    {
        return $this->hasOne(ServiceItem::className(), ['serviceitemid' => 'serviceitemid']);
    }
}
