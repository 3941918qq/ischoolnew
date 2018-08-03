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
use common\models\ZfRolePrivilege;

class MenuWidget extends Widget{
    public $menu;
    //获取菜单数据
    public function init(){
        parent::init();
        $role_id= \yii::$app->view->params['role_id'];
        if($role_id){
            $groupList=ZfRolePrivilege::find()->select('group')->where(['role_id'=>$role_id])->orderBy('group')->indexBy('group')->asArray()->all();
            foreach($groupList as $group=>$value){
                $arr[]=$group;
            }
            $PriList=ZfRolePrivilege::find()->where(['role_id'=>$role_id])->orderBy('group')->asArray()->all();
            foreach($arr as $group){
                foreach($PriList as $k=>$v){
                    if($v['group']==$group){
                       $array[$group][$k]=$v;
                    }
                }
            }
            $this->menu=$array;
        }      
    }
    //run
    public function run(){
        $str='<ul class="pull-left list-group" style="width: 20%;min-width: 180px;">';
        foreach($this->menu as $group=>$info){
            $data=explode('-',$group);
            $str.='<li class="list-group-item text-center gz_pot">
                <img class="gz_left" src="../img/'.$data[1].'.png" />
                <span style="font-size: 16px;">'.$data[0].'</span>
                <img class="gz_right" src="../img/pc_dw.png" />
            </li><li class="list-group-item gz_xuanx">';
            foreach($info as $v){
              $str.='<a href="/'.$v['controller'].'/'.$v['action'].'"><h5 class="list-group-item-heading text-center">'.$v['alias'].'</h5></a>';
            }

        }
        $str.='</li></ul>';
        return $str;
    }
}
