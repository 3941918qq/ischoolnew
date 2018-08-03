<?php
namespace frontend\models;
use common\models\ZfFamilyNumber;
use common\models\ZfRole;
use common\models\ZfTeacherClass;
class ApproveTeacher extends \yii\base\Model
{
    public $role_id;
    public $ispass;
    public $id;
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['role_id', 'ispass','id'], 'required'],
            ['ispass', 'validateRole'],
        ];
    }
    
    public function validateRole($attribute, $params){
        if (!$this->hasErrors()) {            
            if($this->role_id==0 && $this->ispass==1){
                $this->addError($attribute, '请指定角色后再审核.');
            }else if($this->role_id!=0 && $this->ispass==0){
                $this->addError($attribute, '请将状态变更为已审核.');
            }
            
        }
    }
    public function approve(){
        if ($this->validate()) {
             $tea=ZfTeacherClass::findOne($this->id);
             $tea->role_id=$this->role_id;
             $tea->ispass=$this->ispass;
             return ($tea->save(false)) ? true : false;            
         }else{
            $error=$this->ErrorInfo();       
            echo "<script>alert('".$error."');window.location='/manage/allteacher';</script>"; 
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
            'ispass'=>'状态'
        ];
    }
    public function getRole(){
        return ZfRole::find()->select(['name','id'])->where(['<>','name','校长'])->andWhere(['<>','name','家长'])->indexBy('id')->column();
    }
}

