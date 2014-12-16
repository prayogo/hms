<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_serviceitem".
 *
 * @property integer $serviceitemid
 * @property string $name
 * @property integer $rate
 *
 * @property PsExtraservice[] $psExtraservices
 */
class ServiceItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_serviceitem';
    }

    public $varRate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['varRate'], 'string', 'max' => 20],
            ['rate', 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'serviceitemid' => 'ID',
            'name' => 'Name',
            'rate' => 'Rate',
            'rateFormat' => 'Rate',
            'varRate' => 'Rate'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraServices()
    {
        return $this->hasMany(ExtraService::className(), ['serviceitemid' => 'serviceitemid']);
    }

    public function getrateFormat(){
        return str_replace(',', '.', number_format($this->rate));
    }
}
