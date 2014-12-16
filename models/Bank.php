<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_bank".
 *
 * @property integer $bankid
 * @property string $name
 * @property string $accountno
 * @property string $branch
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'accountno'], 'required','message'=>'Bank Information: {attribute} cannot be blank.'],
            [['name'], 'string', 'max' => 50,'tooLong'=>'Bank Information: {attribute} should contain at most 50 characters.'],
            [['accountno'], 'string', 'max' => 20,'tooLong'=>'Bank Information: {attribute} should contain at most 20 characters.'],
            [['branch'], 'string', 'max' => 150,'tooLong'=>'Bank Information: {attribute} should contain at most 150 characters.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bankid' => 'ID',
            'name' => 'Name',
            'accountno' => 'Account No.',
            'branch' => 'Branch',
        ];
    }
}
