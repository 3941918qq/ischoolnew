<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\ZfUser;
use common\models\ZfTeacherClass;
use common\models\ZfRole;
use common\models\ZfNotice;
use common\models\ZfNews;
use common\models\ZfColumn;
use common\models\ZfSchool;
use common\models\ZfSlide;
class BaseData extends Model
{
   public function getRoleid($uid){
        $user =ZfUser::findOne($uid);
        if($user['role_type']=='teacher'){
            $teaInfo= ZfTeacherClass::findOne(['t_id'=>$uid]);
            return $teaInfo['role_id'];
        }else if($user['role_type']=='parent'){
            $parInfo= ZfRole::findOne(['name'=>'家长']);
            return $parInfo['id'];
        }else{
            return $this->redirect(['/index/login']);
        }
   }
   
   public function getSid($uid){
        $user =ZfUser::findOne($uid);
        return $user['last_sid'];
   }
   /**
    * 查找该校最新动态和公告
    * 查找该校栏目信息
    */
   public function findNewNoticeNews($sid){
       //学校
       $school=ZfSchool::findOne($sid);
       //公告
       $notice=ZfNotice::find()->where(['sid'=>$sid])->orderBy('submitTime DESC')->asArray()->one();
       //动态
       $news=ZfNews::find()->where(['sid'=>$sid])->orderBy('submitTime DESC')->asArray()->one();
       //栏目信息
       $column =ZfColumn::find()->where(['sid'=>$sid])->orderBy('submitTime DESC')->asArray()->all();
       //轮播图
       $slide=ZfSlide::find()->where(['sid'=>$sid])->orderBy('created DESC')->limit(4)->asArray()->all();
       $data['notice']=$notice;
       $data['news']=$news;
       $data['column']=$column;
       $data['school']=$school;
       $data['slide']=$slide;
       return $data;
   }
}

