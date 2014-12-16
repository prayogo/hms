<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_tax".
 *
 * @property integer $taxid
 * @property integer $room
 * @property integer $meal
 * @property integer $product
 * @property string $currency
 */
class Tax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room', 'meal', 'product'], 'integer', 'message'=>'Tax Configuration: {attribute} must be an integer.'],
            [['currency'], 'required', 'message'=>'Tax Configuration: {attribute} cannot be blank.'],
            [['currency'], 'string', 'max' => 5, 'tooLong'=>'Tax Configuration: {attribute} should contain at most 5 characters.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taxid' => 'Taxid',
            'room' => 'Room',
            'meal' => 'Meal',
            'product' => 'Product',
            'currency' => 'Currency',
        ];
    }
}
