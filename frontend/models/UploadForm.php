<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\models\ZfSlide;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,gif,JPEG','message'=>'请上传图片文本'],
        ];
    }
    
    public function upload($sid=null)
    {
        if ($this->validate()) {
            $filename=$sid.time().rand(1,9999);
            if(!file_exists('uploads/lunbo/')){
                mkdir('uploads/lunbo/', 0777,true);
            }   
            $picurl='uploads/lunbo/' . $filename . '.' . $this->file->extension;
            $this->file->saveAs($picurl);
            $models=new ZfSlide;
            $models->sid=$sid;
            $models->picurl=$picurl;
            $models->created=date('Y-m-d H:i:s',time());
            return ($models->save(false)) ? true : false;
        } else {
            return false;
        }
    }
}

