<?php
namespace frontend\models;
use yii;
use common\models\ZfParentStudent;
use common\models\ZfStudents;
use common\models\ZfUser;
class BindStudent extends \yii\base\Model
{
    public $pro_id;
    public $city_id;
    public $county_id;
    public $school_id;
    public $class_id;
    public $stuname;
    public $parent_id;
    private $_stu;
    
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['pro_id', 'city_id','county_id','school_id','class_id','stuname','parent_id'], 'required'],
            [['class_id','stuname'], 'validateStudent'],
            [['parent_id'],'safe']
            
        ];
    }
    //验证该班有没有对应学生
    public function validateStudent($attribute, $params){
        if (!$this->hasErrors()) {
             $student=$this->getStu();
             if(!$student){
                 $this->addError($attribute,'该班没有对应学生，请重新绑定！');
             }
             $pastudent=$this->getPastudent();
             if($pastudent){
                 $this->addError($attribute,'您已经绑定过这个学生了！');
             }
         }
    }
    public function  bind($uid){
        if ($this->validate()) {
             $models=new ZfParentStudent;
             $models->parent_id=$uid;
             $models->stu_id=$this->_stu['id'];
             $models->created=date('Y-m-d H:i:s',time());
             $models->sid=$this->school_id;
             $res=$models->save(false);
             $user=ZfUser::findOne($this->parent_id);
             $user->last_sid=$this->school_id;
             $user->last_stuid=$this->_stu['id'];
             $res_user=$user->save(false);
             if(!$res || !$res_user){
                  echo "<script>alert('申请失败，请重试！');window.location='/parent/myinfo';</script>";
             }else return true;
        } 
        
        $error=$this->ErrorInfo();
        echo "<script>alert('".$error."');window.location='/parent/myinfo';</script>";
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
            'stuname'=>'学生姓名',
            'parent_id'=>'家长id'
        ];
    }
    
    protected function getStu()
    {
        if ($this->_stu === null) {            
            $this->_stu=ZfStudents::find()->where(['name'=>$this->stuname,'class_id'=>$this->class_id])->one();
        }
        return $this->_stu;
    }
    
    protected function getPastudent(){
        if ($this->_stu != null) {
             $res =ZfParentStudent::find()->where(['parent_id'=>$this->parent_id,'stu_id'=>$this->_stu['id']])->one();
        }
        return $res;
    }
}



