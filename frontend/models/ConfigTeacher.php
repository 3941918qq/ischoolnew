<?php
namespace frontend\models;

use yii;
use common\models\ZfFamilyNumber;
use common\models\ZfRole;
use common\models\ZfCourse;
use common\models\ZfTeacherClass;

class ConfigTeacher extends \yii\base\Model
{
    public $role_id;
    public $t_id;
    public $id;
    public $course_id;
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['role_id', 't_id','id','course_id'], 'required'],
            ['course_id','validateCourse']
        ];
    }
    
    public function validateCourse($attribute, $params){
        if (!$this->hasErrors()) {            
            if($this->getTeaRole()){
                 $this->addError($attribute, '该班级已经有指定老师了.');
            }
        }
    }
    public function config($sid){
        if ($this->validate()) {
             $tea= new ZfTeacherClass;
             $tea->t_id=$this->t_id;
             $tea->c_id=$this->id;
             $tea->role_id=$this->role_id;
             $tea->course_id=$this->course_id;
             $tea->sid=$sid;
             $tea->ispass=1;
             $tea->created=date('Y-m-d H:i:s',time());
             return ($tea->save(false)) ? true : false;            
         }else{
            $error=$this->ErrorInfo();       
            echo "<script>alert('".$error."');window.location='/manage/allclass';</script>"; 
            return false;
         }
    }
    public function ErrorInfo(){
        $tmp_earr     = $this->getFirstErrors();
        foreach( $this->activeAttributes() as $ati ) {
            if( isset( $tmp_earr[$ati] ) && !empty( $tmp_earr[$ati] ) ){
                return $tmp_earr[$ati]; 
            }              
        }       
    }
    public function attributeLabels(){
        return[
            'role_id'=>'分配角色',
            't_id'=>'老师',
            'course_id'=>'学科',
        ];
    }
    public function getRole(){
        return ZfRole::find()->select(['name','id'])->where(['<>','name','校长'])->andWhere(['<>','name','家长'])->indexBy('id')->column();
    }
    public function getCourse(){
        return ZfCourse::find()->select(['name','id'])->indexBy('id')->column();
    }
    public function getAlltea(){
        $sid=\yii::$app->view->params['sid'];
        $tea=ZfTeacherClass::find()->select(['zf_teacher_class.t_id'])->with('t')->where(['zf_teacher_class.sid'=>$sid])->asArray()->all();
        foreach($tea as $v){
            $arr[$v['t_id']]=$v['t']['name'];
        }
        return $arr;
    }
    
    public function getTeaRole(){
        return  ZfTeacherClass::find()->where(['c_id'=>$this->id,'course_id'=>$this->course_id,'ispass'=>'1'])->one();
    }
}



