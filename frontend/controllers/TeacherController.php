<?php
namespace frontend\controllers;

use frontend\models\ChengJi;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\ZfRolePrivilege;
use frontend\models\User;
use frontend\models\ImPost;
use common\models\ZfUser;
use common\models\ZfStudents;
use common\models\ZfStudentLeave;
use frontend\models\StudentsSearch;
use frontend\models\SafeCardSearch;
use frontend\models\TeacherClass;
use frontend\models\BindForm;
use frontend\models\ChangePwd;
use frontend\models\AddLxr;
use frontend\models\StudentLeaveSearch;


/**
 * Index controller
 */
class TeacherController extends  BaseController{
    public $layout='main';
    
    /**
     * 我的资料首页面
     * @return type
     */
    public function actionMyinfo(){
        $uid=\yii::$app->view->params['uid'];    
        $userInfo= ZfUser::findOne($uid);   
        $role_id = \yii::$app->view->params['role_id']; 
        if($this->checkRole($role_id)=="校长"){
            return $this->redirect(['/manage/myinfo']);
        }else if($this->checkRole($role_id)=="家长"){
            return $this->redirect(['/parent/myinfo']);
        }
        $teaInfo=TeacherClass::getTeacherInfo($uid);
        $model=new BindForm;
        if ($model->load(Yii::$app->request->post()) && $model->bind($uid)) {
             echo "<script>alert('已提交申请，请耐心等待审核！');window.location='/teacher/myinfo';</script>";
        }else{
            return $this->render('myinfo',[
                   'userInfo'=>$userInfo,
                   'teaInfo'=>$teaInfo,
                   'model'=>$model
            ] );
        } 
        
    }
    /**
     * 个人信息-我的资料修改
     * @return type
     */
    public function actionUpinfo(){
       $model =ZfUser::findOne(Yii::$app->request->post('id'));
       $model->load(Yii::$app->request->post(),'');
       if ($model->load(Yii::$app->request->post(),'') && $model->validate()&& $model->save()) {
            return  $this->FormatJson('修改成功');
        }else{
            return  $this->FormatJson($model->errors['tel'][0]);
        }
    }
    /**
     * 老师取消绑定班级
     * @param type $id
     * @return type
     * @throws ForbiddenHttpException
     */
    public function actionDelclass($id){
        if(isset($id)){
           $res=TeacherClass::delclass($id);
        }else throw new ForbiddenHttpException('拒绝此操作.'); 
        if($res){
            \Yii::$app->session->setFlash("info", "取消成功");
            return $this->redirect(['myinfo']);
        }else  \Yii::$app->session->setFlash("info", "取消失败");
        
    }

    /**
     * 学生信息
     */
    public function actionStuinfo(){
        $uid=\yii::$app->view->params['uid'];       
        $searchModel = new StudentsSearch();
        $arr_cid=$searchModel::findCid($uid);
        $cid=empty($arr_cid)?array(0):$arr_cid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$cid);
        $model=new AddLxr();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {            
            return $this->redirect(['stuinfo']);
        }else{
            return $this->render('stuinfo', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model'=>$model
            ]);
        }
        
    }
    
    public function actionSafecard(){
        $uid=\yii::$app->view->params['uid']; 
        $searchModel = new SafeCardSearch();
        $arr_stu=$searchModel::findAllStudents($uid);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$arr_stu);
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export"){  
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$arr_stu,$type=1);
            foreach($dataProvider->getModels() as $t){
                 $arr[] = $t->attributes;
            }
            $array=$searchModel->getInfo($arr);
            $array_values =[
                'stuname' => '学生姓名',
                'info' => '进/出校',
                'ctime_date' => '刷卡时间',
                'rectime_date' => '接收时间'
            ];
            $array_keys = array_keys($array_values);
            \moonland\phpexcel\Excel::export([
                    'models' => $array,
                    'columns' => $array_keys, 
                    'headers' => $array_values,
                    'fileName' => "safecard.xlsx"
            ]);
        }else{
            return $this->render('safecard',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }
        
    }
    //请假管理
    public function actionLeave(){
        $uid=\yii::$app->view->params['uid'];       
        $searchModel = new StudentLeaveSearch();
        $arr_stu=$searchModel::findAllStudents($uid);
       
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$arr_stu);
        return $this->render('leave',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);       
    }
    public function actionApprove($id){
       if($id){
           $models=ZfStudentLeave::findOne($id);
           $models->flag=1;
           $models->save(false);
           return $this->redirect(['leave']);
       }else throw new ForbiddenHttpException('拒绝此操作.');
    }
    public function actionRefuse($id){
       if($id){
           $models=ZfStudentLeave::findOne($id);
           $models->flag=3;
           $models->save(false);
           return $this->redirect(['leave']);
       }else throw new ForbiddenHttpException('拒绝此操作.');
    }
    //成绩管理模块
    public function actionChengji(){
        $uid=\yii::$app->view->params['uid'];
        $info = ChengJi::teachengji($uid);
        return $this->render('chengji',[
            'info'=>$info
        ]);
    }

    //上传成绩单
    public function actionUploadcjd(){
        $params = \Yii::$app->request->post();
        return ChengJi::import($params);
    }
    //删除成绩单
    public function actionDelcjd(){
        $params = \Yii::$app->request->post();
        return ChengJi::delcjd($params);
    }

    //成绩查询信息
    public function actionQuerychengji(){
        $params = Yii::$app->request->post();
        $params['stuid'] = "all";
        $res = ChengJi::searchChengji($params);
        return $res;
    }

    //学生请假
    public function actionDoleave(){
        $uid=\yii::$app->view->params['uid'];
        $post_params = \yii::$app->request->post();
        $post_params['uid'] = $uid;
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = StudentLeaveSearch::savelevel($post_params);
        if ($result ==1){
            echo "<script>alert('请假成功，请耐心等待审核！');window.location='/teacher/stuinfo';</script>";
        }else{
            echo "<script>alert('请假失败，请重新提交信息！');window.location='/teacher/stuinfo';</script>";
        }
    }
    //家校沟通
    public function actionJxnotice(){
        $uid=\yii::$app->view->params['uid'];       
        $result= ImPost::getParList($uid);    
        $parList=json_encode($result['parlist']);
        return $this->render('jxnotice',[
            'token'=>$result['token'],
            'parList'=>$parList,
            'appkey'=>\yii::$app->params['IM_APPKEY']
        ]);
    }
    //内部交流
     public function actionTalk(){
        $uid=\yii::$app->view->params['uid'];       
        $result= ImPost::getTalkList($uid);    
        $parList=json_encode($result['parlist']);  
        return $this->render('talk',[
            'token'=>$result['token'],
            'parList'=>$parList,
            'appkey'=>\yii::$app->params['IM_APPKEY']
        ]);
    }
}