<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfParentStudent;
use common\models\ZfUser;
use common\models\ZfStudents;
use common\models\ZfClass;
use common\models\ZfSchool;
/**
 * ZfParentStudentSearch represents the model behind the search form of `common\models\ZfParentStudent`.
 */
class ZfParentStudentSearch extends ZfParentStudent
{
    public function attributes(){
        return array_merge(parent::attributes(),['parent_name','parent_tel','stu_name','class','cid','school']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'stu_id', 'sid'], 'integer'],
            [['created','parent_tel','stu_name','class','cid','school','parent_name'], 'safe'],
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
        $query = ZfParentStudent::find();

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
            'zf_parent_student.id' => $this->id,
            'zf_parent_student.parent_id' => $this->parent_id,
            'zf_parent_student.stu_id' => $this->stu_id,
            'zf_parent_student.created' => $this->created,
            'zf_parent_student.sid' => $this->sid,
        ]);

        $query->join('inner join','zf_students','zf_students.id =zf_parent_student.stu_id ');
        $query->join('inner join','zf_user','zf_user.id = zf_parent_student.parent_id ');
        $query->join('inner join','zf_school','zf_school.id = zf_parent_student.sid ');
        $query->join('inner join','zf_class','zf_students.class_id = zf_class.id ');

        $query->andFilterWhere(['like','zf_user.name',$this->parent_name]);
        $query->andFilterWhere(['like','zf_user.tel',$this->parent_tel]);
        $query->andFilterWhere(['like','zf_students.name',$this->stu_name]);
        $query->andFilterWhere(['like','zf_students.class_id',$this->cid]);
        $query->andFilterWhere(['like','zf_school.name',$this->school]);
        $query->andFilterWhere(['like','zf_class.name',$this->class]);


        return $dataProvider;
    }

    public function getInfo($data){
        foreach ($data as $key => $value) {
            $user=ZfUser::findOne(['id'=>$value['parent_id']]);
            $student=ZfStudents::findOne(['id'=>$value['stu_id']]);
            $cid=$student->attributes['class_id'];
            $class=ZfClass::findOne(['id'=>$cid]);
            $school=ZfSchool::findOne(['id'=>$value['sid']]);
            $data[$key]['tel']=$user->attributes['tel'];
            $data[$key]['name']=$user->attributes['name'];  
            $data[$key]['stu_name']=$student->attributes['name'];        
            $data[$key]['class']=$class->attributes['name'];
            $data[$key]['class_id']=$class->attributes['id'];                      
            $data[$key]['school']=$school->attributes['name'];
        }
        return $data;
    }
}
