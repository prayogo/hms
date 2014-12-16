<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SeasonalRate;

/**
 * SeasonalRateSearch represents the model behind the search form about `app\models\SeasonalRate`.
 */
class SeasonalRateSearch extends SeasonalRate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seasonalrateid'], 'integer'],
            [['name', 'description', 'startdate', 'enddate', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], 'safe'],
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
        $query = SeasonalRate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'seasonalrateid' => $this->seasonalrateid,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mon', $this->mon])
            ->andFilterWhere(['like', 'tue', $this->tue])
            ->andFilterWhere(['like', 'wed', $this->wed])
            ->andFilterWhere(['like', 'thu', $this->thu])
            ->andFilterWhere(['like', 'fri', $this->fri])
            ->andFilterWhere(['like', 'sat', $this->sat])
            ->andFilterWhere(['like', 'sun', $this->sun]);

        return $dataProvider;
    }
}
