<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RoomType;

/**
 * RoomTypeSearch represents the model behind the search form about `app\models\RoomType`.
 */
class RoomTypeSearch extends RoomType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomtypeid', 'singleb', 'doubleb', 'extrab', 'maxchild', 'maxadult', 'childcharge', 'adultcharge', 'rate', 'weekendrate'], 'integer'],
            [['name', 'description'], 'safe'],
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
        $query = RoomType::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'roomtypeid' => $this->roomtypeid,
            'singleb' => $this->singleb,
            'doubleb' => $this->doubleb,
            'extrab' => $this->extrab,
            'maxchild' => $this->maxchild,
            'maxadult' => $this->maxadult,
            'childcharge' => $this->childcharge,
            'adultcharge' => $this->adultcharge,
            'rate' => $this->rate,
            'weekendrate' => $this->weekendrate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
