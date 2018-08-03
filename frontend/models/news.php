<?php

namespace frontend\models;

use Yii;
use common\models\ZfNews;
class News extends ZfNews{
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
                $models=ZfNews::findOne($id);
            }else{
                $models=new ZfNews;
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
    




