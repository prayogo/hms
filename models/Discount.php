<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discount".
 *
 * @property integer $discountid
 * @property double $percent
 * @property integer $rate
 * @property string $from_date
 * @property string $to_date
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['percent'], 'number'],
            [['rate'], 'integer'],
            [['from_date', 'to_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'percent' => 'Percent',
            'rate' => 'Rate',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
        ];
    }
}
