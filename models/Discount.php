<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_discount".
 *
 * @property integer $discountid
 * @property string $name
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

    public $discountby = 'P';
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'discountby'], 'required'],
            [['percent'], 'number'],
            [['rate'], 'integer'],
            [['from_date', 'to_date', 'amount'], 'safe'],
            [['name'], 'string', 'max' => 50],
            ['amount', 'compare', 'compareValue' => 0, 'operator' => '>'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discountid' => 'Discountid',
            'name' => 'Name',
            'percent' => 'Percent',
            'rate' => 'Discount Rate',
            'from_date' => 'From',
            'to_date' => 'To',
            'discountby' => 'Discount By',
            'amount' => 'Discount Rate',
            'rateFormat' => 'Discount Rate',
            'fromDateFormat' => 'From',
            'toDateFormat' => 'To'
        ];
    }
    
    public function getRateFormat(){
        $tax = \app\models\Tax::find()->one();

        if ($this->percent){
            return $this->percent . "%";
        }else if ($this->rate){
            return $tax->currency . ' ' . number_format($this->rate);
        }
    }

    public function getFromDateFormat(){
        if ($this->from_date){
            return date("d-M-Y", strtotime($this->from_date));
        }
    }

    public function getToDateFormat(){
        if ($this->to_date){
            return date("d-M-Y", strtotime($this->to_date));
        }

        return 'Now';
    }
}
