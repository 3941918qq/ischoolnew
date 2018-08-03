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
use common\models\ZfTeacherClass;
use common\models\ZfParentStudent;

class ToggleRoleWidget extends Widget{
    public $toggleRole;
    //获取菜单数据
    public function init(){
        parent::init();
        $role_id= \yii::$app->view->params['role_id'];
        $uid=\yii::$app->view->params['uid'];
        if($role_id){
            //获取当前role
            $role=ZfRole::find()->where(['id'=>$role_id])->one();
            $now_role=$role['name'];
            //获取该用户所有的role           
            $arr_role=[];
            $teaInfo=ZfTeacherClass::find()->where(['t_id'=>$uid,'ispass'=>'1'])->groupBy('role_id')->asArray()->all();           
            if($teaInfo){
                foreach($teaInfo as $k=>$v){
                    $models=ZfRole::find()->where(['id'=>$v['role_id']])->one();
                    $arr_role[$models['id']]=$models['name'];
                }               
            }else{
                $models=ZfRole::find()->where(['name'=>'普通老师'])->one();
                $arr_role[$models['id']]=$models['name'];
            }
            $model=ZfRole::find()->where(['name'=>'家长'])->one();
            $arr_role[$model['id']]=$model['name'];
            $data['nowrole']=$now_role;
        }else{           
            $model=ZfRole::find()->where(['name'=>'家长'])->one();
            $arr_role[$model['id']]=$model['name'];           
        }
        $data['allrole']=$arr_role;
        $data['uid']=$uid;
        $this->toggleRole=$data;
    }
    //run
    public function run(){
//        echo "<pre>";
//        var_dump($this->toggleRole);die;
        $str='<div class="dropdown" style="display: inline-block;">
            <div class="btn-group">
                <button class="btn btn-default">切换身份</button>
                <div class="btn-group">
                    <button class="btn btn-default" data-toggle="dropdown">
                        '.$this->toggleRole['nowrole'].'
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">';
                    foreach($this->toggleRole['allrole'] as $role_id => $role_name){
                        $str.= ' <li><a onclick="changeRole(this)" href="###" name="'.$this->toggleRole['uid'].'" id="'.$role_id.'">'.$role_name.'</a></li>';
                    }                   
                $str.='</ul>
                </div>
            </div>
        </div>';
        return $str;
    }
}


