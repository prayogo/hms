<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerid'], 'integer'],
            [['name', 'address', 'email', 'npwp', 'locationid', 'birthdate', 'comment', 'blacklist', 'varPhone', 'varIdentification'], 'safe'],
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
        $query = Customer::find()->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->joinWith(['customerphones']);
        $query->joinWith(['customeridentifications']);

        $dataProvider->sort->attributes['varPhone'] = [
            'asc' => ['ps_customer.customerid' => SORT_ASC],
            'desc' => ['ps_customer.customerid' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['varIdentification'] = [
            'asc' => ['ps_customer.customerid' => SORT_ASC],
            'desc' => ['ps_customer.customerid' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'customerid' => $this->customerid,
            'birthdate' => $this->birthdate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['like', 'locationid', $this->locationid])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'blacklist', $this->blacklist])
            ->andFilterWhere(['like', 'ps_customeridentification.identificationno', $this->varIdentification])
            ->andFilterWhere(['like', 'ps_customerphone.phone', $this->varPhone]);

        return $dataProvider;
    }
}
