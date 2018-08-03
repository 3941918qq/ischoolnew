<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\ZfStudents;
use common\models\ZfTeacherClass;
use yii\helpers\ArrayHelper;
/**
 * ZfStudentsSearch represents the model behind the search form of `common\models\ZfStudents`.
 */
class StudentsSearch extends \common\models\ZfStudentsSearch
{   
    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
            [['id', 'class_id', 'school_id'], 'integer'],
            [['name', 'stu_no','class'], 'safe'],
        ];
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$cid)
    {
       
        $query = ZfStudents::find()->where(['in','class_id',$cid]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 11,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'zf_students.id' => $this->id,
            'zf_students.class_id' => $this->class_id,
            'zf_students.school_id' => $this->school_id,
        ]);
        $query->andFilterWhere(['like', 'zf_students.name', $this->name])
            ->andFilterWhere(['like', 'zf_students.stu_no', $this->stu_no])
            ->andFilterWhere(['like', 'zf_students.epc_no', $this->epc_no])
            ->andFilterWhere(['like', 'zf_students.tel_no', $this->tel_no]);
        $query->join('inner join','zf_class','zf_students.class_id = zf_class.id');
        $query->andFilterWhere(['like','zf_class.name',$this->class]);
        return $dataProvider;
    }

    public function findCid($uid){
        $class=ZfTeacherClass::findAll(['t_id'=>$uid,'ispass'=>'1']);       
        foreach($class as $k=>$cid){
              $arr_cid[$k]=$cid->attributes['c_id']; 
        }
        return $arr_cid;
    }
    
    
}


