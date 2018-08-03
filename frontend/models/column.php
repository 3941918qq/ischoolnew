<?php
namespace frontend\models;
use common\models\ZfFamilyNumber;
use common\models\ZfColumn;
use yii\web\UploadedFile;
class Column extends \yii\base\Model
{
    public $title;
    public $sketch;
    public $content;
    public $columnPicture;
    public function rules()
    {
        return [
            // 在这里定义验证规则
            [['title','content'], 'required'],
            [['content','title','sketch'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['sketch'], 'string', 'max' => 200],
            [['columnPicture'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,JPEG','message'=>'请上传图片文本'],
        ];
    }
    public function attributeLabels(){
        return[
            'title'=>'标题',
            'sketch'=>'简介',
            'content'=>'内容',
            'columnPicture'=>'封面图片'
        ];
    }
    public function editcol($id){          
        if ($this->validate()) {
            $models=ZfColumn::findOne($id);
            $models->title=$this->title;
            if($this->sketch){
                $models->sketch=$this->sketch;
            }           
            $models->content=$this->content;
            return ($models->save(false)) ? true : false;
         } else return false;
    }
    public function upload($id){
        $models=ZfColumn::findOne($id);
        $filename=$id.time().rand(1,9999);
        if(!file_exists('uploads/column/')){
             mkdir('uploads/column/', 0777,true);
        }   
        $picurl='uploads/column/' . $filename . '.' . $this->columnPicture->extension;
        $this->columnPicture->saveAs($picurl);
        $models->columnPicture='/'.$picurl;
        return ($models->save(false)) ? true : false;
    }

}





