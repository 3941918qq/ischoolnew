<?php

namespace frontend\models;

use Yii;
use common\models\ZfNotice;
class Notice extends ZfNotice{
    /**
     * @inheritdoc
     */
    public $title; 
    public $content;
    public function rules()
    {
        return [
            [['title','content'], 'required'],
 
        ];
    }    
   /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
        ];
    }
    
    public function fabu($sid,$uid,$id){
        if ($this->validate()) {           
            if($id){
                $models=ZfNotice::findOne($id);
            }else{
                $models=new ZfNotice;
            }
            $models->sid=$sid;
            $models->title=$this->title;
            $models->content=$this->content;
            $models->submitTime=date('Y-m-d H:i:s',time());
            $models->uid=$uid;
            return ($models->save(false)) ? true : false;
        }
        return false;
    }
}
    


