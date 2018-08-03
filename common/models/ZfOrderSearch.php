<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfOrder;

/**
 * ZfOrderSearch represents the model behind the search form of `common\models\ZfOrder`.
 */
class ZfOrderSearch extends ZfOrder
{
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stu_id', 'uid'], 'integer'],
            [['total'], 'number'],
            [['inside_no', 'trade_name', 'paytype', 'ispasspa', 'ispassjx', 'ispassqq', 'ispassck', 'ispass', 'submitTime', 'updateTime', 'trans_id', 'type'], 'safe'],
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
        $query = ZfOrder::find();

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
            'total' => $this->total,
            'submitTime' => $this->submitTime,
            'updateTime' => $this->updateTime,
            'stu_id' => $this->stu_id,
            'uid' => $this->uid,
        ]);

        $query->andFilterWhere(['like', 'inside_no', $this->inside_no])
            ->andFilterWhere(['like', 'trade_name', $this->trade_name])
            ->andFilterWhere(['like', 'paytype', $this->paytype])
            ->andFilterWhere(['like', 'ispasspa', $this->ispasspa])
            ->andFilterWhere(['like', 'ispassjx', $this->ispassjx])
            ->andFilterWhere(['like', 'ispassqq', $this->ispassqq])
            ->andFilterWhere(['like', 'ispassck', $this->ispassck])
            ->andFilterWhere(['like', 'ispass', $this->ispass])
            ->andFilterWhere(['like', 'trans_id', $this->trans_id])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
