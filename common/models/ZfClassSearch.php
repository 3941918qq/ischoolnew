<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfClass;
use common\models\ZfSchool;
/**
 * ZfClassSearch represents the model behind the search form of `common\models\ZfClass`.
 */
class ZfClassSearch extends ZfClass
{
    public function attributes(){
        return array_merge(parent::attributes(),['school_name']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'class', 'sid'], 'integer'],
            [['name', 'created','school_name'], 'safe'],
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
        $query = ZfClass::find();

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
            'zf_class.id' => $this->id,
            'zf_class.level' => $this->level,
            'zf_class.class' => $this->class,
            'zf_class.sid' => $this->sid,
            'zf_class.created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'zf_class.name', $this->name]);
        $query->join('inner join','zf_school','zf_school.id=zf_class.sid');
        $query->andFilterWhere(['like','zf_school.name',$this->school_name]);
        return $dataProvider;
    }

    public function getInfo($data){
        foreach ($data as $key => $value) {
           $res =ZfSchool::findOne(['id'=>$value['sid']]);
           $data[$key]['school']=$res->attributes['name'];
        }
        return $data;
    }
}
