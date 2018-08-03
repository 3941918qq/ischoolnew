<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfSchool;
use common\models\ZfProvince;
use common\models\ZfCity;
use common\models\ZfCounty;
use common\models\ZfSchoolType;
/**
 * ZfSchoolSearch represents the model behind the search form of `common\models\ZfSchool`.
 */
class ZfSchoolSearch extends ZfSchool
{
    public function attributes(){
        return array_merge(parent::attributes(),['county_name']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pro_id', 'city_id', 'county_id', 'sch_type'], 'integer'],
            [['name', 'setting', 'created', 'ispass', 'ckpass', 'skpass', 'papass', 'jxpass', 'qqpass', 'xfpass', 'month_total', 'half_total', 'year_total', 'is_youhui','county_name'], 'safe'],
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
        $query = ZfSchool::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination'=>[
                'pageSize'=>20,
            ],
            'sort'=>[
                'defaultOrder'=>[
                    'id'=>'SORT_ASC'
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'zf_school.id' => $this->id,
            'zf_school.pro_id' => $this->pro_id,
            'zf_school.city_id' => $this->city_id,
            'zf_school.county_id' => $this->county_id,
            'zf_school.sch_type' => $this->sch_type,
            'zf_school.created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'zf_school.name', $this->name])
            ->andFilterWhere(['like', 'setting', $this->setting])
            ->andFilterWhere(['like', 'ispass', $this->ispass])
            ->andFilterWhere(['like', 'ckpass', $this->ckpass])
            ->andFilterWhere(['like', 'skpass', $this->skpass])
            ->andFilterWhere(['like', 'papass', $this->papass])
            ->andFilterWhere(['like', 'jxpass', $this->jxpass])
            ->andFilterWhere(['like', 'qqpass', $this->qqpass])
            ->andFilterWhere(['like', 'xfpass', $this->xfpass])
            ->andFilterWhere(['like', 'month_total', $this->month_total])
            ->andFilterWhere(['like', 'half_total', $this->half_total])
            ->andFilterWhere(['like', 'year_total', $this->year_total])
            ->andFilterWhere(['like', 'is_youhui', $this->is_youhui]);
        $query->join('inner join','zf_county','zf_school.county_id = zf_county.id');
        $query->andFilterWhere(['like','zf_county.name',$this->county_name]);
        return $dataProvider;
    }
    public function getInfo($data){
        foreach ($data as $key => $value) {
            $pro=ZfProvince::findOne(['id'=>$value['pro_id']]);
            $city=ZfCity::findOne(['id'=>$value['city_id']]);
            $county=ZfCounty::findOne(['id'=>$value['county_id']]);
            $schtype=ZfSchoolType::findOne(['id'=>$value['sch_type']]);
            $data[$key]['pro']=$pro->attributes['name'];
            $data[$key]['city']=$city->attributes['name'];
            $data[$key]['county']=$county->attributes['name'];
            $data[$key]['schooltype']=$schtype->attributes['name'];
        }
        return $data;
    }
}
