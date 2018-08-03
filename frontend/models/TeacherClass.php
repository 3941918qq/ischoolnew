<?php

namespace frontend\models;

use Yii;
use common\models\ZfTeacherClass;
use common\models\ZfSchoolType;
use common\models\ZfClass;
use common\models\ZfParentStudent;
class TeacherClass extends ZfTeacherClass{
    /**
     * 获取我绑定的所有班级信息
     */
    public function getTeacherInfo($uid){
        $info=ZfTeacherClass::find()->with('course','c','s')->where(['zf_teacher_class.t_id'=>$uid])->andWhere(['<>','role_id','10001'])->all();
        return $info;
    }
    /**
     * 获取我绑定的所有学校
     */
    public function getSchoolInfo($uid){
        $info=ZfTeacherClass::find()->with('s')->where(['zf_teacher_class.t_id'=>$uid,'role_id'=>10001])->asArray()->all();
        foreach($info as $key=>$school){           
            $schoolType=ZfSchoolType::findOne($school['s']['sch_type']);
            $info[$key]['s']['school_type']=$schoolType['name'];
        }
        return $info;
    }
    /**
     * 获取我所绑定的孩子
     */
     public function getStuInfo($uid){
        $info=ZfParentStudent::find()->with('s','stu')->where(['zf_parent_student.parent_id'=>$uid])->asArray()->all();       
        foreach($info as $key=>$value){           
            $class=ZfClass::findOne($value['stu']['class_id']);
            $info[$key]['class']=$class['name'];
        }
        return $info;       
     }
    /**
     * 取消绑定老师
     */
     public function delclass($id){
        return  $res=ZfTeacherClass::deleteAll(['id'=>$id]);
     }
}

