<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\ZfTeacherClass;
/**
 * ZfStudentsSearch represents the model behind the search form of `common\models\ZfStudents`.
 */
class TeacherClassSearch extends \common\models\ZfTeacherClassSearch
{   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 't_id', 'c_id', 'role_id', 'course_id', 'level', 'sid'], 'integer'],
            [['ispass', 'created','name','school','class','role','course','tel'], 'safe'],
        ];
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$school_id)
    {
        $query = ZfTeacherClass::find()->where(['zf_teacher_class.sid'=>$school_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 11,
            ],
            'sort' => [
                'defaultOrder' => [
                    'ispass' => SORT_DESC,
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
            'zf_teacher_class.id' => $this->id,
            'zf_teacher_class.t_id' => $this->t_id,
            'zf_teacher_class.c_id' => $this->c_id,
            'zf_teacher_class.role_id' => $this->role_id,
            'zf_teacher_class.course_id' => $this->course_id,
            'zf_teacher_class.level' => $this->level,
            'zf_teacher_class.sid' => $this->sid,
            'zf_teacher_class.created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'zf_teacher_class.ispass', $this->ispass]);

        $query->join('inner join','zf_user','zf_user.id=zf_teacher_class.t_id');
        $query->join('inner join','zf_school','zf_school.id=zf_teacher_class.sid');
        $query->join('inner join','zf_class','zf_class.id=zf_teacher_class.c_id');
        $query->join('inner join','zf_course','zf_course.id=zf_teacher_class.course_id');
        $query->join('inner join','zf_role','zf_role.id=zf_teacher_class.role_id');

//
        $query->andFilterWhere(['like','zf_user.name',$this->name]);
        $query->andFilterWhere(['like','zf_user.tel',$this->tel]);       
        $query->andFilterWhere(['like','zf_school.name',$this->school]);       
        $query->andFilterWhere(['like','zf_class.name',$this->class]);       
        $query->andFilterWhere(['like','zf_course.name',$this->course]);
        $query->andFilterWhere(['like','zf_role.name',$this->role]);


        return $dataProvider;
    }

    public function findAllTeachers($uid){
        $res=ZfTeacherClass::find()->select('sid')->where(['role_id'=>'10001','t_id'=>$uid])->one();       
        return $res->attributes['sid'];
    }
    
    
}




