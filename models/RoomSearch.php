<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Room;

/**
 * RoomSearch represents the model behind the search form about `app\models\Room`.
 */
class RoomSearch extends Room
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomid', 'floorid', 'roomtypeid', 'roomstatusid'], 'integer'],
            [['name', 'lockid', 'description', 'varfloor', 'varroomtype', 'varroomstatus'], 'safe'],
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
        $query = Room::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['floor']);
        $query->joinWith(['roomtype']);
        $query->joinWith(['roomstatus']);

        $dataProvider->sort->attributes['varfloor'] = [
            'asc' => ['ps_floor.name' => SORT_ASC],
            'desc' => ['ps_floor.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['varroomtype'] = [
            'asc' => ['ps_roomtype.name' => SORT_ASC],
            'desc' => ['ps_roomtype.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['varroomstatus'] = [
            'asc' => ['ps_roomstatus.name' => SORT_ASC],
            'desc' => ['ps_roomstatus.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'roomid' => $this->roomid,
            'floorid' => $this->floorid,
            'roomtypeid' => $this->roomtypeid,
            'roomstatusid' => $this->roomstatusid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'lockid', $this->lockid])
            ->andFilterWhere(['like', 'ps_room.description', $this->description])
            ->andFilterWhere(['like', 'ps_floor.name', $this->varfloor])
            ->andFilterWhere(['like', 'ps_roomtype.name', $this->varroomtype])
            ->andFilterWhere(['like', 'ps_roomstatus.name', $this->varroomstatus]);

        return $dataProvider;
    }
}
