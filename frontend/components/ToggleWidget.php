<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\components;

use yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\ZfRole;
use common\models\ZfParentStudent;
use common\models\ZfTeacherClass;
use common\models\ZfUser;

class ToggleWidget extends Widget{
    public $toggle;
    //获取菜单数据
    public function init(){
        parent::init();
        $role_id= \yii::$app->view->params['role_id'];
        $uid= \yii::$app->view->params['uid'];
        if($role_id){
            //获取当前role
            $role=ZfRole::find()->where(['id'=>$role_id])->one();
            $now_role=$role['name'];
            switch ($role['name']){
                case '家长':
                    $toggleLabel='当前学生';
                    break;
                default:
                    $toggleLabel='当前学校';
            }
            $arr=array();
            $data=array();
            if($toggleLabel=='当前学生'){
                //查找该用户绑定所有学生以及当前学生
                $result=ZfParentStudent::find()->with('stu')->where(['parent_id'=>$uid])->asArray()->all();
                $user=ZfUser::find()->with('lastStu')->where(['id'=>$uid])->asArray()->one();
                $now=$user['lastStu']['name'];               
                foreach($result as $k=>$v){
                    $arr[$k]['id']=$v['stu_id'];
                    $arr[$k]['name']=$v['stu']['name'];
                }
                $data['type']='parent';
            }else{
                //查找该用户所有学校以及当前学校
                $result=ZfTeacherClass::find()->with('s')->where(['t_id'=>$uid,'ispass'=>1])->groupBy('sid')->asArray()->all();
                $user=ZfUser::find()->with('lastS')->where(['id'=>$uid])->asArray()->one();
                $now=$user['lastS']['name'];
                foreach($result as $k=>$v){
                    $arr[$k]['id']=$v['sid'];
                    $arr[$k]['name']=$v['s']['name'];
                }
                $data['type']='teacher';
            }
            $data['toggleLabel']=$toggleLabel;
            $data['allresult']=$arr;
            $data['now']=$now;
            $data['uid']=$uid;
            $this->toggle=$data;
        }
      
    }
    //run
    public function run(){
        $str='<div class="btn-group">
                <button class="btn btn-default">'.$this->toggle['toggleLabel'].'</button>
                <div class="btn-group">
                    <button class="btn btn-default" data-toggle="dropdown">
                        '.$this->toggle['now'].'
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">';
                    foreach($this->toggle['allresult'] as $key => $value){
                        $str.= ' <li><a onclick="change(this)" href="###"  data="'.$this->toggle['uid'].'" name="'.$this->toggle['type'].'" id="'.$value['id'].'">'.$value['name'].'</a></li>';
                    }                   
                $str.='</ul>
                </div>
            </div>';
        return $str;
    }
}




