<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Discount;

/**
 * DiscountSearch represents the model behind the search form about `app\models\Discount`.
 */
class DiscountSearch extends Discount
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['discountid'], 'integer'],
            [['name', 'rate'], 'string'],
            [['from_date', 'to_date'], 'safe'],
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
        $query = Discount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'rate', $this->rate]);
        $query->orFilterWhere(['like', 'concat(percent, \'%\')', $this->rate]);

        $query->andFilterWhere([ 'like', 'name', $this->name ]);
        $query->andFilterWhere([ 'like', 'date_format(from_date, \'%d-%b-%Y\')', $this->from_date ]);
        $query->andFilterWhere([ 'like', 'coalesce(date_format(to_date, \'%d-%b-%Y\'), \'Now\')', $this->to_date ]);

        return $dataProvider;
    }
}
