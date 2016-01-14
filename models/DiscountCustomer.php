<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discountcustomer".
 *
 * @property integer $discountid
 * @property integer $customerid
 *
 * @property PsCustomer $customer
 */
class DiscountCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_discountcustomer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discountid', 'customerid'], 'required'],
            [['discountid', 'customerid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'customerid' => 'Customerid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(PsCustomer::className(), ['customerid' => 'customerid']);
    }
}
