<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_seasonalrate".
 *
 * @property integer $seasonalrateid
 * @property string $name
 * @property string $description
 * @property string $startdate
 * @property string $enddate
 * @property string $mon
 * @property string $tue
 * @property string $wed
 * @property string $thu
 * @property string $fri
 * @property string $sat
 * @property string $sun
 *
 * @property PsSeasonalratedetail[] $psSeasonalratedetails
 */
class SeasonalRate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_seasonalrate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'startdate', 'enddate'], 'required'],
            [['startdate', 'enddate'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250],
            [['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seasonalrateid' => 'Seasonalrateid',
            'name' => 'Name',
            'description' => 'Description',
            'startdate' => 'Startdate',
            'enddate' => 'Enddate',
            'mon' => 'Mon',
            'tue' => 'Tue',
            'wed' => 'Wed',
            'thu' => 'Thu',
            'fri' => 'Fri',
            'sat' => 'Sat',
            'sun' => 'Sun',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsSeasonalratedetails()
    {
        return $this->hasMany(PsSeasonalratedetail::className(), ['seasonalrateid' => 'seasonalrateid']);
    }
}
