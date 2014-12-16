<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RoomReservation;

/**
 * RoomReservationSearch represents the model behind the search form about `app\models\RoomReservation`.
 */
class RoomReservationSearch extends RoomReservation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roomreservationid', 'roomid', 'customerid', 'deposit', 'roomstatusid'], 'integer'],
            [['startdate', 'enddate', 'cancel'], 'safe'],
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
        $query = RoomReservation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'roomreservationid' => $this->roomreservationid,
            'roomid' => $this->roomid,
            'customerid' => $this->customerid,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'deposit' => $this->deposit,
            'roomstatusid' => $this->roomstatusid,
        ]);

        $query->andFilterWhere(['like', 'cancel', $this->cancel]);

        return $dataProvider;
    }
}
