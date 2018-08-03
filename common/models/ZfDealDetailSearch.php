<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfDealDetail;

/**
 * ZfDealDetailSearch represents the model behind the search form of `common\models\ZfDealDetail`.
 */
class ZfDealDetailSearch extends ZfDealDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created', 'school_id'], 'integer'],
            [['pos_sn', 'card_no', 'type', 'ser_no'], 'safe'],
            [['amount', 'balance'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ZfDealDetail::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'created' => $this->created,
            'school_id' => $this->school_id,
        ]);

        $query->andFilterWhere(['like', 'pos_sn', $this->pos_sn])
            ->andFilterWhere(['like', 'card_no', $this->card_no])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ser_no', $this->ser_no]);

        return $dataProvider;
    }
}
