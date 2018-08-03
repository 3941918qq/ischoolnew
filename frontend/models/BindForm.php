<?php
namespace frontend\models;
use yii;
use common\models\ZfTeacherClass;
use common\models\ZfUser;
class BindForm extends \yii\base\Model
{
    public $pro_id;
    public $city_id;
    public $county_id;
    public $school_id;
    public $class_id;
    public $course_id;
    private $_tea;
    
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['pro_id', 'city_id','county_id','school_id','class_id','course_id'], 'required'],
            [['school_id','class_id','course_id'], 'validateTeaclass'],
            
        ];
    }
    public function validateTeaclass($attribute, $params){
         if (!$this->hasErrors()) {
             $teaclass=$this->getTea();
             if($teaclass){
                 $this->addError($attribute,'该班级已经有对应的任课老师了，请重新绑定.');
             }
             
         }   
         
    }
    public function  bind($uid){
        if ($this->validate()) {
             $models=new ZfTeacherClass;
             $models->t_id=$uid;
             $models->c_id=$this->class_id;
             $models->course_id=$this->course_id;
             $models->sid=$this->school_id;
             $models->ispass=0;
             $models->created=date('Y-m-d H:i:s',  time());
             $res=$models->save(false);    
//             $user=ZfUser::findOne($uid);
//             $user->last_sid=$this->school_id;
//             $res_user=$user->save(false);
             if(!$res){
                  echo "<script>alert('申请失败，请重试！');window.location='/teacher/myinfo';</script>";
             }else return true;
        } 
        
        $error=$this->ErrorInfo();
//        var_dump($error);die;
        echo "<script>alert('".$error."');window.location='/teacher/myinfo';</script>";
        return false;
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
            'pro_id'=>'省',
            'city_id'=>'市',
            'county_id'=>'县区',
            'school_id'=>'学校',
            'class_id'=>'班级',
            'course_id'=>'学科'
           
        ];
    }
    
    protected function getTea()
    {
        if ($this->_tea === null) {            
            $this->_tea = ZfTeacherClass::find()
                    ->where(['sid'=>$this->school_id,'c_id'=>$this->class_id,'course_id'=>$this->course_id,'ispass'=>1])->one();
        }
        return $this->_tea;
    }
}

