<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_identificationtype".
 *
 * @property integer $identificationtypeid
 * @property string $name
 *
 * @property PsCustomeridentification[] $psCustomeridentifications
 */
class IdentificationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_identificationtype';
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
            'identificationtypeid' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsCustomeridentifications()
    {
        return $this->hasMany(CustomerIdentification::className(), ['identificationtypeid' => 'identificationtypeid']);
    }
}
