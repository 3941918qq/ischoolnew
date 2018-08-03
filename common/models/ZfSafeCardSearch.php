<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfSafeCard;

/**
 * ZfSafeCardSearch represents the model behind the search form of `common\models\ZfSafeCard`.
 */
class ZfSafeCardSearch extends ZfSafeCard
{
    public function attributes(){
        return array_merge(parent::attributes(),['stuname','creat_stamptime','receive_stamptime']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stuid', 'ctime', 'yearmonth', 'yearweek', 'weekday', 'receivetime'], 'integer'],
            [['info','stuname'], 'safe'],
            [['creat_stamptime','receive_stamptime'],'date','format' => 'php:Y-m-d H:i:s','message'=>'请输入正确的日期格式']
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
        $query = ZfSafeCard::find();

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
        $this->receivetime=($this->receive_stamptime)? strtotime($this->receive_stamptime):$this->receivetime;
        $this->ctime=($this->creat_stamptime)?strtotime($this->creat_stamptime):$this->ctime;
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'stuid' => $this->stuid,
            'ctime' => $this->ctime,
            'yearmonth' => $this->yearmonth,
            'yearweek' => $this->yearweek,
            'weekday' => $this->weekday,
            'receivetime' => $this->receivetime,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info]);
        $query->join('inner join','zf_students','zf_students.id = zf_safe_card.stuid');
        $query->andFilterWhere(['like', 'zf_students.name', $this->stuname]);
        return $dataProvider;
    }
    
    public function getInfo($data){
        foreach ($data as $key => $value) {
             $data[$key]['ctime_date']=date('Y-m-d H:i:s',$value['ctime']);
             $data[$key]['rectime_date']=date('Y-m-d H:i:s',$value['receivetime']);
             $res =ZfStudents::findOne(['id'=>$value['stuid']]);
             $data[$key]['stuname']=$res['name'];
        } 
        return $data;
    }
}
