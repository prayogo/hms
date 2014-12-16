<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_customeridentification".
 *
 * @property integer $customerid
 * @property integer $identificationtypeid
 * @property string $identificationno
 *
 * @property PsCustomer $customer
 * @property PsIdentificationtype $identificationtype
 */
class CustomerIdentification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_customeridentification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerid', 'identificationtypeid', 'identificationno'], 'required'],
            [['customerid', 'identificationtypeid'], 'integer'],
            [['identificationno'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerid' => 'Customerid',
            'identificationtypeid' => 'Identificationtypeid',
            'identificationno' => 'Identification',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(PsCustomer::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationtype()
    {
        return $this->hasOne(IdentificationType::className(), ['identificationtypeid' => 'identificationtypeid']);
    }
}
