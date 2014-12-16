<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExtraService;

/**
 * ExtraServiceSearch represents the model behind the search form about `app\models\ExtraService`.
 */
class ExtraServiceSearch extends ExtraService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extraserviceid', 'serviceitemid', 'roomreservationid', 'quantity'], 'integer'],
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
        $query = ExtraService::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'extraserviceid' => $this->extraserviceid,
            'serviceitemid' => $this->serviceitemid,
            'roomreservationid' => $this->roomreservationid,
            'quantity' => $this->quantity,
        ]);

        return $dataProvider;
    }
}
