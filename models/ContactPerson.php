<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_contactperson".
 *
 * @property integer $contactpersonid
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $phone2
 */
class ContactPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_contactperson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','phone'], 'required', 'message'=>'Contact Person: {attribute} cannot be blank.'],
            [['name'], 'string', 'max' => 50, 'tooLong'=>'Contact Person: {attribute} should contain at most 50 characters.'],
            [['address', 'email'], 'string', 'max' => 150, 'tooLong'=>'Contact Person: {attribute} should contain at most 150 characters.'],
            [['phone', 'phone2'], 'string', 'max' => 20, 'tooLong'=>'Contact Person: {attribute} should contain at most 20 characters.'],
            ['email','email', 'message'=>'Contact Person: {attribute} is not a valid email address.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contactpersonid' => 'Contactpersonid',
            'name' => 'Name',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone 1',
            'phone2' => 'Phone 2 (Optional)',
        ];
    }
}
