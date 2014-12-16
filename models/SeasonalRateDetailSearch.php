<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SeasonalRateDetail;

/**
 * SeasonalRateDetailSearch represents the model behind the search form about `app\models\SeasonalRateDetail`.
 */
class SeasonalRateDetailSearch extends SeasonalRateDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seasonalratedetailid', 'seasonalrateid', 'roomid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SeasonalRateDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'seasonalratedetailid' => $this->seasonalratedetailid,
            'seasonalrateid' => $this->seasonalrateid,
            'roomid' => $this->roomid,
        ]);

        return $dataProvider;
    }
}
