<?php

namespace backend\models;

use Yii;
use common\models\ZfStudents;
use common\models\ZfClass;
use common\models\ZfCardLibrary;
use common\models\ZfUser;
use common\models\ZfParentStudent;
/**
 * This is the model class for table "zf_access_token".
 *
 * @property int $id 访问令牌
 * @property string $access_token 访问令牌
 * @property string $last_time 上次请求保存时间，超过2小时重新请求并更新
 */
class Import extends \yii\base\Model{

	//学生信息
	static public function ImportStudent($data){
            foreach ($data as $k=>$v){
                $student = new ZfStudents();
                $stuNum['stu_no']=$v['C'];
                $res =  $student->findOne($stuNum);
                if($res){
                        return "学号为".$v['C']."的数据已存在!";
                }
            }

            foreach ($data as $k=>$v){
                $student = new ZfStudents();
                $class = new ZfClass();
                $map['sid'] = $v['A'];
                $map['level'] = $v['D'];
                $map['class'] = $v['E'];
                $stuClass = $class->find()->where($map)->select("id")->asArray()->one();

                if(isset($stuClass) && !empty($stuClass)){
                    $student->school_id = $v['A'];
                    $student->name = $v['B'];
                    $student->stu_no = $v['C'];
                    $student->class_id = $stuClass['id'];
                    $res=$student->save(false);             
                }else{
                    return '学号为'.$v['C'].'的学生的班级不存在!';
                }
            }
            return "导入成功";
	}
	//电话卡
	static public function ImportPhones($data)
	{
            foreach ($data as $k=>$v){
                $student = new ZfStudents();
                $res = $student->findOne(['stu_no'=>$v['A']]);
                if(!$res) continue;
                $res->tel_no = $v['B'];
                 $result=$res->save(false);			
	    }
	     return "操作成功";
	}
	//EPC
	static public function ImportEpc($data)
	{
            foreach ($data as $k=>$v){
                $student = new ZfStudents();
                $res = $student->findOne(['stu_no'=>$v['A']]);
                if(!$res) continue;
                $res->epc_no = $v['B'];
                $result=$res->save(false);			
            }
	    return "操作成功";
	}
	//卡库
	static public function ImportKaku($data)
	{
	    foreach ($data as $k=>$v){			
                $re = ZfCardLibrary::findOne(['cardno'=>$v['A']]);
                if($re) continue;
                $res = new ZfCardLibrary();
                $res->cardno = $v['A'];
                $res->epcno = $v['B'];
                $res->telno = $v['C'];
                $res->created = date("Y-m-d H:i:s",time());
                $result=$res->save(false);			
	    }
	    return "操作成功";
	}
         //epc电话卡
        static public function ImportEpcTel($data)
	{
            foreach ($data as $k=>$v){
                $student = new ZfStudents();
                $res = $student->findOne(['stu_no'=>$v['A']]);                
                if(!$res) continue;
                $res->epc_no = $v['B'];
                $res->tel_no = $v['C'];
                try {
                    if(!$res->save(false)){
                        throw new \Exception($v['A'].'已存在。');
                    }                  
                } catch (\yii\db\Exception $e) {
                    return $e->getMessage();
                }
            }
            return "操作成功";
	}
        //用户信息
	static public function ImportUser($data)
	{
	    foreach ($data as $k=>$v){	
                $stu=ZfStudents::find()->select('id')->where(['name'=>$v['A'],'class_id'=>$v['B'],'school_id'=>$v['C']])->asArray()->one();
                if($stu){
                    $re = ZfUser::findOne(['tel'=>$v['E']]);
                    if($re) return "电话".$v['E']."已经存在";               
                    $res = new ZfUser();
                    $res->name = $v['D'];
                    $res->tel = $v['E'];
                    $res->password = md5(substr($v['E'],5));
                    $res->role_type = 'parent';
                    $res->is_pass =1;
                    $res->last_sid =$v['C'];
                    $res->last_stuid =$stu['id'];
                    $res->updated = date("Y-m-d H:i:s",time());
                    try {
                        if(!$res->save(false)){
                             throw new \Exception("用户信息保存失败！");
                        }                  
                    } catch (\yii\db\Exception $e) {
                        return $e->getMessage();
                    }
                    $pa=new ZfParentStudent;
                    $pa->parent_id=$res->attributes['id'];
                    $pa->stu_id=$stu['id'];
                    $pa->sid=$v['C'];
                    $pa->created = date("Y-m-d H:i:s",time());
                    $pa->save(false);
                }else{
                    return "学生".$v['A']."不存在";
                }
                			
	    }
	    return "操作成功";
	}
        
}