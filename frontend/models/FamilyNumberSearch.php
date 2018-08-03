<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfFamilyNumber;

/**
 * ZfFamilyNumberSearch represents the model behind the search form of `common\models\ZfFamilyNumber`.
 */
class FamilyNumberSearch extends ZfFamilyNumber
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stu_id'], 'integer'],
            [['tel', 'relation', 'created'], 'safe'],
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
    public function search($params,$stu_id)
    {
        $query = ZfFamilyNumber::find()->where(['stu_id'=>$stu_id]);

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
            'stu_id' => $this->stu_id,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'relation', $this->relation]);

        return $dataProvider;
    }
}
