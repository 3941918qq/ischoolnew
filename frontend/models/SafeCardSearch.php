<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\ZfSafeCard;
use common\models\ZfTeacherClass;
use common\models\ZfStudents;
use common\models\ZfStudentLeave;
use common\models\ZfParentStudent;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
/**
 * ZfStudentsSearch represents the model behind the search form of `common\models\ZfStudents`.
 */
class SafeCardSearch extends \common\models\ZfSafeCardSearch
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$allstu,$type=null)
    {
        $query = ZfSafeCard::find()->where(['in','stuid',$allstu]);

        // add conditions that should always apply here
        
        
        if($type==1){
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' =>false,
                'sort' => [
                    'defaultOrder' => [
                        'receivetime' => SORT_DESC,
                        'ctime' => SORT_DESC,
                    ]
                ],
            ]);
        }else{
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 11,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'receivetime' => SORT_DESC,
                        'ctime' => SORT_DESC,
                    ]
                ],
            ]);
        }
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $this->receivetime=($this->receive_stamptime)? strtotime($this->receive_stamptime):$this->receivetime;
        $this->ctime=($this->creat_stamptime)?strtotime($this->creat_stamptime):$this->ctime;
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'stuid' => $this->stuid,
//            'ctime' => $this->ctime,
            'yearmonth' => $this->yearmonth,
            'yearweek' => $this->yearweek,
            'weekday' => $this->weekday,
//            'receivetime' => $this->receivetime,
        ]);
        $query->andFilterWhere(['>=', 'ctime', $this->ctime]);
        $query->andFilterWhere(['>=', 'receivetime', $this->receivetime]);
        $query->andFilterWhere(['like', 'info', $this->info]);
        $query->join('inner join','zf_students','zf_students.id = zf_safe_card.stuid');
        $query->andFilterWhere(['like', 'zf_students.name', $this->stuname]);
        return $dataProvider;
    }
    /**
     * 
     * @param type $uid
     * @return typ查找该老师的所有学生
     */
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
    /**
     * 该校所有学生
     */
    public function SchoolAllStudents($sid){
       $allstu=ZfStudents::find()->select('id')->where(['school_id'=>$sid])->asArray()->all();
       foreach($allstu as $k=>$v){
           $arr[$k]= $v['id'];
       }
       return (isset($arr))? $arr:[];
    }
    /**
     * 该班级下的所有学生的平安通知信息
     */
    public function findCidSafeInfo($cid,$time=null){
        $arr= self::CidGetStu($cid);
        $arr=(isset($arr))? $arr:[];
        $query=ZfSafeCard::find()->with('stu')->where(['in','stuid',$arr]);
        if($time){
            $starttime=$time;
            $endtime=$time+86399;
            $query->andWhere(['between','receivetime',$starttime,$endtime]);
        }
        $count=$query->count();       
        $pagination = new Pagination([
            'defaultPageSize' =>20,
            'totalCount' => $count]);
        $data=$query->orderBy('receivetime DESC')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()->all();
        $info=array();
        $info['pagination']=$pagination;
        $info['data']=$data;
        return $info;
    }
    /**
     * 该班所有学生的请假信息
     */
    public function findCidLeaveInfo($cid){
        $arr= self::CidGetStu($cid);
        $arr=(isset($arr))? $arr:[];
        $query= ZfStudentLeave::find()->with('stu')->where(['and','flag=1',['in','stu_id',$arr]]);
        $count=$query->count();       
        $pagination = new Pagination([
            'defaultPageSize' =>20,
            'totalCount' => $count]);
        $data=$query->orderBy('passTime DESC')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()->all();
        $info=array();
        $info['pagination']=$pagination;
        $info['data']=$data;
        return $info;
    }
    
    public function CidGetStu($cid){
        $stu=ZfStudents::findAll(['class_id'=>$cid]);
        $arr=array();
        foreach ($stu as $key=>$info){
            $arr[$key]=$info->attributes['id'];
        }
        return $arr;
    }
    public function findAllChilds($uid){
        $stuinfo=ZfParentStudent::find()->where(['parent_id'=>$uid])->asArray()->all();
        if($stuinfo){
            $arr=array();
            foreach($stuinfo as $key=>$value){
                $arr[$key]=$value['stu_id'];
            }
            return $arr;
        }else return [];
        
    }
}




