<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfStudents;
use common\models\ZfClass;
use yii\helpers\ArrayHelper;
/**
 * ZfStudentsSearch represents the model behind the search form of `common\models\ZfStudents`.
 */
class ZfStudentsSearch extends ZfStudents
{
    public function attributes(){
        return array_merge(parent::attributes(),['class','school']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'class_id', 'school_id'], 'integer'],
            [['name', 'stu_no', 'sex', 'epc_no', 'tel_no', 'enddatejx', 'upendtimejx', 'enddateqq', 'upendtimeqq', 'enddateck', 'upendtimeck', 'enddatepa', 'upendtimepa','class','school'], 'safe'],
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
        $query = ZfStudents::find();

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
            'zf_students.id' => $this->id,
            'zf_students.class_id' => $this->class_id,
            'zf_students.school_id' => $this->school_id,
            'zf_students.enddatejx' => $this->enddatejx,
            'zf_students.upendtimejx' => $this->upendtimejx,
            'zf_students.enddateqq' => $this->enddateqq,
            'zf_students.upendtimeqq' => $this->upendtimeqq,
            'zf_students.enddateck' => $this->enddateck,
            'zf_students.upendtimeck' => $this->upendtimeck,
            'zf_students.enddatepa' => $this->enddatepa,
            'zf_students.upendtimepa' => $this->upendtimepa,
        ]);

        $query->andFilterWhere(['like', 'zf_students.name', $this->name])
            ->andFilterWhere(['like', 'zf_students.stu_no', $this->stu_no])
            ->andFilterWhere(['like', 'zf_students.sex', $this->sex])
            ->andFilterWhere(['like', 'zf_students.epc_no', $this->epc_no])
            ->andFilterWhere(['like', 'zf_students.tel_no', $this->tel_no]);
        $query->join('inner join','zf_class','zf_students.class_id = zf_class.id');
        $query->join('inner join','zf_school','zf_students.school_id = zf_school.id');
        $query->andFilterWhere(['like','zf_class.name',$this->class]);
        $query->andFilterWhere(['like','zf_school.name',$this->school]);
        return $dataProvider;
    }

    public function getInfo($data){
        foreach ($data as $key => $value) {
            $class=ZfClass::findOne(['id'=>$value['class_id']]);
            $data[$key]['class']=$class->attributes['name'];
      
        }
        return $data;
    }
    //批量操作
    public function batchUpdate($params,$enddatepa,$enddateqq,$enddatejx,$enddateck)
    {
    	$query = ZfStudents::find();
    	Yii::trace($params);
    	$this->load($params);
    	if (!$this->validate()) {
    		return false;
    	}

    	$query->andFilterWhere([
    		'id' => $this->id,
    		'stu_no' => $this->stu_no,
            "enddatepa" => $this->enddatepa,
            "enddateqq" => $this->enddateqq,
            "enddatejx" => $this->enddatejx,
            "enddateck" => $this->enddateck
        ]);
        $query->join('inner join','zf_class','zf_students.class_id = zf_class.id');
        $query->join('inner join','zf_school','zf_students.school_id = zf_school.id');
        $query->andFilterWhere(['like', 'zf_students.name', $this->name]);
         $query->andFilterWhere(['like','zf_class.name',$this->class]);
        $query->andFilterWhere(['like','zf_school.name',$this->school]);
        $all_ids = $query->asArray()->all();
    	$format_ids = ArrayHelper::getColumn($all_ids, "id");
        $update_data = [];
        if($enddatejx)
        {
            $update_data =array_merge($update_data,['enddatejx'=>$enddatejx,'upendtimejx' => date("Y-m-d H:i:s",time())]);
        }
        if($enddatepa){
            $update_data =array_merge($update_data,['enddatepa'=>$enddatepa,'upendtimepa' => date("Y-m-d H:i:s",time())]);
        }
        if($enddateqq){
            $update_data =array_merge($update_data,['enddateqq'=>$enddateqq,'upendtimeqq' => date("Y-m-d H:i:s",time())]);
        }
        if($enddateck){
            $update_data =array_merge($update_data,['enddateck'=>$enddateck,'upendtimeck' => date("Y-m-d H:i:s",time())]);
        }

        ZfStudents::updateAll($update_data,["id"=>$all_ids]);
        if(($enddatepa != "") || ($enddateqq != "") || ($enddatejx != "") || ($enddateck != "")){
            foreach($all_ids as $key=>$val){
                $orderSd = new ZfOrder();
                $orderSd->trade_name = $val['school']."|".$val['class']."|".$val['name']."|".$val['id'];
                $orderSd->paytype ="SDTJ";
                $orderSd->ispasspa = ($enddatepa != "")?1:0;
                $orderSd->ispassqq = ($enddateqq != "")?1:0;
                $orderSd->ispassjx = ($enddatejx != "")?1:0;
                $orderSd->ispassck = ($enddateck != "")?1:0;
                $orderSd->submitTime =date('Y-m-d H:i:s',time());
                $orderSd->updateTime =date('Y-m-d H:i:s',time());
                $orderSd->stu_id =$val['id'];
                $orderSd->save();
            }
        }
        return true;

    }
}
