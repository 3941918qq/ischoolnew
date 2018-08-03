<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\ZfUser;
use common\models\ZfClass;
use common\models\ZfTeacherClass;
use common\models\ZfParentStudent;
use common\models\ZfStudents;
use common\models\ZfImMessage;
class ImPost extends Model
{
    protected function getToken($uid){
        $url="http://api.cn.ronghub.com/user/getToken.json";
        $portraitUri='/img/0206_28.png';
        $user = ZfUser::findOne($uid);
        $session = Yii::$app->session;
        $session['userId']=$user['tel'];
        $data="userId=".$user['tel']."&name=".$user['name']."&portraitUri=".$portraitUri;        
        $result=self::PostCurl($url,$data);
        if(isset($result) && $result['code']=='200'){   
            $token=$result['token'];
        } 
        return $token;
    }
    //获取家校沟通家长联系人列表
    public function getParList($uid){  
        $portraitUri='/img/0206_28.png';     
        $token=self::getToken($uid);
         //获取该老师家长列表         
        $allrole=ZfTeacherClass::find()->select('c_id')->where(['t_id'=>$uid,'ispass'=>1])->asArray()->all();
        foreach($allrole as $cid){
            $arr_cid[]=$cid['c_id'];
        }
        $arr_cid=is_null($arr_cid)?[]:$arr_cid;
        $resu= ZfUser::find()->select('zf_user.tel as targetId,zf_user.name,s.name as stuname')
                ->join('LEFT JOIN','zf_parent_student p','zf_user.id = p.parent_id')
                ->join('LEFT JOIN','zf_students s','p.stu_id = s.id')
                ->where(['in','s.class_id',$arr_cid])->groupBy('zf_user.tel')->asArray()->all();        
        foreach($resu as $k=>$v){
            $resu[$k]['portraitUri']=$portraitUri;
        }
//        $resu=[
//            0=>['targetId'=>'10000',
//                'name'=>'客服小白',
//                'stuname'=>'',
//                'portraitUri'=>'/img/0206_28.png'
//                ]
//        ];
        $return['token']=$token;
        $return['parlist']=$resu;
        
        return $return;
    }
    //获取家校沟通老师联系人列表
    public function getTeaList($uid){
        $portraitUri='/img/0206_28.png';     
        $token=self::getToken($uid);
        //获取该家长所绑定学生的所有老师 
        $tea_id= ZfUser::find()->select('c.t_id,c.c_id')
                ->join('INNER JOIN','zf_parent_student p','zf_user.id = p.parent_id')
                ->join('INNER JOIN','zf_students s','p.stu_id = s.id')
                ->join('INNER JOIN','zf_teacher_class c','c.c_id = s.class_id')
                ->where(['zf_user.id'=>$uid])->asArray()->groupBy('c.t_id')->all();

       if($tea_id){
           foreach($tea_id as $k=>$v){
               if($v['t_id']!=$uid){
                $teainfo=ZfUser::findOne($v['t_id']);
                $class=ZfClass::findOne($v['c_id']);
                $arr[$k]['targetId']=$teainfo['tel'];
                $arr[$k]['name']=$teainfo['name'];
                $arr[$k]['portraitUri']=$portraitUri;
                $arr[$k]['stuname']=$class['name'];
               }               
           }
       }
       $return['token']=$token;
       $return['parlist']=$arr;
       return $return;
    }
    //内部交流联系人列表获取
    public function getTalkList($uid){
        //获取当前学校ID
       $user=ZfUser::findOne($uid);
       $portraitUri='/img/0206_28.png';
       if($user['last_sid']){
           $resu=ZfTeacherClass::find()->select('zf_user.tel as targetId,zf_user.name')
                   ->join('INNER JOIN','zf_user','zf_teacher_class.t_id=zf_user.id')
                   ->where(['sid'=>$user['last_sid'],'ispass'=>1])->andWhere(['<>','zf_user.id',$uid])->asArray()->all();
           foreach($resu as $k=>$v){
               $resu[$k]['portraitUri']=$portraitUri;
           }
//           var_dump($resu);die;
       }
       
       $token=self::getToken($uid);
       $return['token']=$token;
       $return['parlist']=$resu;
       return $return;
    }
    protected function PostCurl($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $appSecret = \yii::$app->params['IM_APPSECRET']; // 开发者平台分配的 App Secret。       
        $timestamp = time()*1000; // 获取时间戳（毫秒）。
        $nonce = rand(); // 获取随机数。
        $signature = sha1($appSecret.$nonce.$timestamp); 
        //设置header
        $header = array();
        $header[] = 'App-Key:'.\yii::$app->params['IM_APPKEY'];
        $header[] = 'Timestamp:'.$timestamp;
        $header[] = 'Nonce:'.$nonce;
        $header[] = 'Signature:'.$signature;
        $header[] = 'Content-Length:'.strlen($data);
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            return array("errcode"=>-1,"errmsg"=>'发送错误号'.curl_errno($curl).'错误信息'.curl_error($curl));
        }
        curl_close($curl);
        return json_decode($result, true);
    }
    
    //保存发送消息
    public function saveMes($post){
        $im=new ZfImMessage;
        $im->messageType=$post['messageType'];       
        $im->converType=$post['converType'];
        $im->sendId=$post['sendId'];
        $im->targetId=$post['targetId'];
        $im->sendtime=$post['sendtime'];
        $im->messageDirection=1;
        if($post['messageType']=='ImageMessage'){
           $im->url=urldecode($post['imageUri']);
        }else if($post['messageType']=='FileMessage'){
           $im->url=urldecode($post['fileUri']);
           $im->content=$post['name'];
        }else{
           $im->content=$post['content'];
        }
        $res=$im->save(false);
        return ($res) ?'success':'fail';

    }
    //保存接收消息
    public function saveMesRec($post){
        $im=new ZfImMessage;
        if($post['messageType']=='ImageMessage'){
           $im->url=urldecode($post['imageUri']);
        }else if($post['messageType']=='FileMessage'){
           $im->url=urldecode($post['fileUri']);
           $im->content=$post['name'];
        }else{
           $im->content=$post['content'];
        }
        $im->messageType=$post['messageType'];       
        $im->converType=$post['converType'];
        $im->sendId=Yii::$app->session['userId'];
        $im->targetId=$post['targetId'];
        $im->sendtime=$post['sendtime'];
        $im->messageDirection=2;
        $res=$im->save(false);
        return ($res) ? 'success':'fail';
    }
    //获取历史消息
    public function getHisMes($post){
    	$res=ZfImMessage::find()->where(['targetId'=>$post['targetId']])->orderBy('sendtime DESC')->limit(50)->asArray()->all();
    	if($res){
            $res=array_reverse($res);
    		$data=[];
    		foreach($res as $k=>$v){
                    $data[$k]['content']['messageName']=$v['messageType'];
                     $data[$k]['content']['content']= ($v['messageType']=='ImageMessage') ? preg_replace('/\s+/', '', $v['content']) : $v['content'];   			
                    if($v['messageType']=='ImageMessage'){
                        $data[$k]['content']['imageUri']=$v['url'];
                    }else if($v['messageType']=='FileMessage'){
                        $data[$k]['content']['fileUrl']=$v['url']; 
                        $data[$k]['content']['name']=$v['content']; 
                    }
                    $data[$k]['content']['extra']="附加信息";
                    $data[$k]['conversationType']=$v['converType'];
                    $data[$k]['sentTime']=intval($v['sendtime']);
                    $data[$k]['targetId']=$v['targetId'];
                    $data[$k]['messageType']=$v['messageType'];
                    $data[$k]['messageDirection']=$v['messageDirection'];
    		}
    	}
    	return ($data) ? $data : null;
    }
}



