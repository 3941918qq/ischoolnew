<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfUser;

/**
 * ZfUserSearch represents the model behind the search form of `common\models\ZfUser`.
 */
class ZfUserSearch extends ZfUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'last_sid', 'last_stuid'], 'integer'],
            [['name', 'tel', 'password', 'role_type', 'is_pass', 'openid', 'pushid', 'uuid', 'last_login_time', 'register_time', 'updated'], 'safe'],
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
        $query = ZfUser::find();

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
            'last_sid' => $this->last_sid,
            'last_stuid' => $this->last_stuid,
            'last_login_time' => $this->last_login_time,
            'register_time' => $this->register_time,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'role_type', $this->role_type])
            ->andFilterWhere(['like', 'is_pass', $this->is_pass])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'pushid', $this->pushid])
            ->andFilterWhere(['like', 'uuid', $this->uuid]);

        return $dataProvider;
    }
}
