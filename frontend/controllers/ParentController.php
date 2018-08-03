<?php
namespace frontend\controllers;

use common\models\ZfStudentLeave;
use frontend\models\ChengJi;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\ZfClass;
use common\models\ZfFamilyNumber;
use common\models\ZfParentStudent;
use common\models\ZfSchool;
use common\models\ZfStudents;
use common\models\ZfTeacherClass;
use common\models\ZfRolePrivilege;
use common\models\ZfUser;
use frontend\models\User;
use frontend\models\ImPost;
use frontend\models\StudentsSearch;
use frontend\models\TeacherClass;
use frontend\models\BindStudent;
use frontend\models\ChangePwd;
use frontend\models\AddLxr;
use frontend\models\FamilyNumberSearch;
use frontend\models\StudentLeaveSearch;
use frontend\models\SafeCardSearch;
use frontend\models\DealDetailSearch;
use yii\filters\AccessControl;

/**
 * Index controller
 */
class ParentController extends  BaseController{
    public $layout='main';
    /**
     * 我的资料首页面
     * @return type
     */
    public function actionMyinfo(){
        $uid=\yii::$app->view->params['uid'];

        $userInfo= ZfUser::findOne($uid);   
        $role_id = \yii::$app->view->params['role_id'];
        $stuInfo=TeacherClass::getStuInfo($uid);
        $model=new BindStudent;
        if ($model->load(Yii::$app->request->post()) && $model->bind($uid)) {
             echo "<script>alert('绑定成功！');window.location='/parent/myinfo';</script>";
        }else{
            return $this->render('myinfo',[
                   'userInfo'=>$userInfo,
                   'stuinfo'=>$stuInfo,
                   'model'=>$model,
                   'parent_id'=>$uid
            ] );
        }        
    }
    /**
     * 家长取消绑定学生
     * @param type $id
     * @return type
     * @throws ForbiddenHttpException
     */
    public function actionDelstu($id){
        if(isset($id)){
           $res=ZfParentStudent::findOne($id);      
        }else throw new ForbiddenHttpException('拒绝此操作.'); 
        if($res->delete()){
            \Yii::$app->session->setFlash("info", "取消成功");
            return $this->redirect(['myinfo']);
        }else  \Yii::$app->session->setFlash("info", "取消失败");
        
    }
    
    /**
    *学生信息页面
     */
    public function  actionStuinfo(){
        $uid=\yii::$app->view->params['uid'];
        $userInfo= ZfUser::findOne($uid);
        $stu_id = $userInfo['last_stuid'];
        $stuinfo = ZfStudents::findOne($stu_id);
        $data = [];
        $data['stu_id'] = $stu_id;
        $data['class_id'] = $stuinfo['class_id'];
        $data['stu_name'] = $stuinfo['name'];
        $data['school'] = ZfSchool::findOne($stuinfo['school_id'])['name'];
        $data['class'] = ZfClass::findOne($stuinfo['class_id'])['name'];
        $teainfo = ZfTeacherClass::find()->where(['c_id'=>$stuinfo['class_id'],'role_id'=>10003])->one();   //班主任信息
        $data['tea_name'] = ZfUser::findOne($teainfo['t_id'])['name'];
        $data['tel'] = ZfUser::findOne($teainfo['t_id'])['tel'];
        $searchModel = new FamilyNumberSearch();
        \Yii::trace($data);
        $data['qqtel'] = $searchModel->search(Yii::$app->request->queryParams,$stu_id);
        $data['stuleave'] = StudentLeaveSearch::levellist($stu_id);
        $data['chengji'] = ChengJi::Scorequery($stuinfo['class_id']);
        $parents = ZfFamilyNumber::getParents($stu_id);
        return $this->render('stuinfo',[
            'data'=>$data,
            'dataProvider' => $data['qqtel'],
            'searchModel' => $searchModel,
            'parents' => $parents
        ] );
    }


    //学生请假
    public function actionLeave(){
        $uid=\yii::$app->view->params['uid'];
        $post_params = \yii::$app->request->post();
        $post_params['uid'] = $uid;
        $result = StudentLeaveSearch::savelevel($post_params);
        if ($result ==1){
            echo "<script>alert('请假成功，请耐心等待审核！');window.location='/parent/stuinfo';</script>";
        }else{
            echo "<script>alert('请假失败，请重新提交信息！');window.location='/parent/stuinfo';</script>";
        }
    }

    //成绩查询信息
    public function actionDoscorequery(){
        $params = Yii::$app->request->post();
        $res = ChengJi::searchChengji($params);
        return $res;
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
     * 平安通知
     */
    public function actionSafecard(){
        $uid=\yii::$app->view->params['uid']; 
        $searchModel = new SafeCardSearch();
        $arr_stu=$searchModel::findAllChilds($uid);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$arr_stu);      
        return $this->render('safecard',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    /**
     * 餐卡消费记录
     */
    public function actionRecords(){
        $uid=\yii::$app->view->params['uid']; 
        $searchModel = new DealDetailSearch();
        $stuno=$searchModel::getLastStu($uid);
//        var_dump($stuno);die;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$stuno['stu_no']);      
        return $this->render('records',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    //请假被拒绝的信息不再显示
    public function actionQqbxs()
    {
        $id = \Yii::$app->request->get('id');
        if(!empty($id)){
            $models = ZfStudentLeave::findOne($id);
            $models->flag = 0;
            $models->save(false);
        }
        return $this->redirect("/parent/stuinfo");
    }
    
    //家校沟通
    public function actionJxnotice(){
        $uid=\yii::$app->view->params['uid'];       
        $result= ImPost::getTeaList($uid);
        $parList=json_encode($result['parlist']);
        return $this->render('jxnotice',[
            'token'=>$result['token'],
            'parList'=>$parList,
            'appkey'=>\yii::$app->params['IM_APPKEY']
        ]);
    }

}