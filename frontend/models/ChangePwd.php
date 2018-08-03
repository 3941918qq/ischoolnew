<?php
namespace frontend\models;
use common\models\ZfUser;
class ChangePwd extends \yii\base\Model
{
    public $pwd;
    public $newPwd;
    public $reNewPwd;
    private $_user;
   
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['pwd', 'newPwd','reNewPwd'], 'required'],           
            ['pwd', 'validatePassword'],
            ['newPwd', 'compare', 'compareAttribute' => 'pwd','operator' => '!=','message'=>'新密码不能和旧密码相同！'],
            ['reNewPwd', 'compare', 'compareAttribute' => 'newPwd','message'=>'两次输入的新密码不一致！'],
        ];
    }
     public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {            
            $user = $this->getUser();
            if(!$user){
                $this->addError($attribute, '用户名不存在.');
            }else{
                if( $user->password!=md5($this->pwd)){
                    $this->addError($attribute, '当前密码不正确.');
                }              
            }                               
        }
    }
    public function  check(){
        if ($this->validate()) {
            $this->_user->password=md5($this->newPwd);
            $this->_user->save();
            return true;
         } else{
            $error=$this->ErrorInfo();       
            echo "<script>alert('".$error."');</script>"; 
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
    protected function getUser()
    {
        if ($this->_user === null) {            
            $this->_user = ZfUser::findOne(\yii::$app->view->params['uid']);
        }

        return $this->_user;
    }
    
    public function attributeLabels(){
        return[
            'pwd'=>'当前密码',
            'newPwd'=>'新密码',
            'reNewPwd'=>'新密码确认'          
        ];
    }
}

