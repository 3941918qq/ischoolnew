<?php
namespace frontend\models;
use common\models\ZfFamilyNumber;
class AddLxr extends \yii\base\Model
{
    public $relation;
    public $tel;
    public $stuid;
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['tel', 'relation','stuid'], 'required'],
            ['tel','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>"请输入正确的手机号码"],
            ['relation', 'string', 'max' => 255]
        ];
    }
    public function attributeLabels(){
        return[
            'relation'=>'身份',
            'tel'=>'电话',
            'stuid'=>'学生id'
        ];
    }
    public function add(){
           
         if ($this->validate()) {
            $lxr=new ZfFamilyNumber;
            $lxr->stu_id=$this->stuid;
            $lxr->tel=$this->tel;
            $lxr->relation=$this->relation;
            $lxr->created=date('Y-m-d H:i:s',time());        
            $res=$lxr->save(false);
            if($res){
                return true;
            }
            
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
}



