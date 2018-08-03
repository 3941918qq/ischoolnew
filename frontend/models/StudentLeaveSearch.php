<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZfStudentLeave;
use common\models\ZfTeacherClass;
use common\models\ZfStudents;
/**
 * ZfStudentLeaveSearch represents the model behind the search form of `common\models\ZfStudentLeave`.
 */
class StudentLeaveSearch extends ZfStudentLeave
{
    public function attributes(){
        return array_merge(parent::attributes(),['name']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stu_id', 'flag', 'passUid', 'uid'], 'integer'],
            [['startTime', 'endTime', 'ctime', 'reason', 'passTime','name'], 'safe'],
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
    public function search($params,$allstu)
    {
        $query = ZfStudentLeave::find()->where(['in','stu_id',$allstu]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 11,
            ],
            'sort' => [
                'defaultOrder' => [
                    'flag' => SORT_DESC,
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
            'id' => $this->id,
            'stu_id' => $this->stu_id,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'ctime' => $this->ctime,
            'flag' => $this->flag,
            'passTime' => $this->passTime,
            'passUid' => $this->passUid,
            'uid' => $this->uid,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);
        $query->join('inner join','zf_students','zf_student_leave.stu_id=zf_students.id');
        $query->andFilterWhere(['like','zf_students.name',$this->name]);
        return $dataProvider;
    }

    public function savelevel($data){
        $model = new ZfStudentLeave();
        $model->uid = $data['uid'];
        $model -> stu_id = $data['stu_id'];
        // return $data['parent_relation'];
        $model -> startTime = $data['statime'];
        $model -> endTime = $data['endtime'];
        $model -> flag = 2;
        if (isset($data['shenfen']) && $data['shenfen'] == "tea"){
            $model -> flag = 1;
        }
        $model -> ctime = date('Y-m-d H:i:s',time());
        $model->reason = $data['reason'];
        $res = 0;
        if($model->save(false)) $res = 1;
        return $res;
    }

    public function levellist($stu_id){
        $res = ZfStudentLeave::find()->select('zf_student_leave.id,flag,startTime,endTime,zf_user.name')->where(['and',['stu_id'=>$stu_id],'flag != 0'])->joinWith('u')->asArray()->all();
        Yii::trace($res);
        return $res;
    }
    
    public function findAllStudents($uid){
        $class=ZfTeacherClass::findAll(['t_id'=>$uid,'ispass'=>'1']);       
        foreach($class as $k=>$cid){
              $arr_cid[$k]=$cid->attributes['c_id']; 
        }
        $arr_cid=(isset($arr_cid))? $arr_cid:[];
        $allstu=ZfStudents::find()->select('id')->where(['in','class_id',$arr_cid])->asArray()->all();
        foreach($allstu as $k=>$v){
           $arr[$k]= $v['id'];
        }
        return (isset($arr))? $arr:[];
    }
}
