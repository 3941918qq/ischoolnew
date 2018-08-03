<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use common\models\ZfNotice;
use common\models\ZfNews;
use common\models\ZfTeacherClass;
use common\models\ZfUser;
use common\models\ZfSlide;
use common\models\ZfColumn;
use frontend\models\TeacherClassSearch;
use frontend\models\ClassSearch;
use frontend\models\ApproveTeacher;
use frontend\models\TeacherClass;
use frontend\models\BindForm;
use frontend\models\BaseData;
use frontend\models\ConfigTeacher;
use frontend\models\SafeCardSearch;
use frontend\models\ChangePwd;
use frontend\models\SchoolNotice;
use frontend\models\Notice;
use frontend\models\News;
use frontend\models\UploadForm;
use frontend\models\Column;
use frontend\models\ImPost;
/**
 * Index controller
 */
class ManageController extends  BaseController{
    public $layout='main';
    /**
     * 我的资料首页面
     * @return type
     */
    public function actionMyinfo(){
        $uid=\yii::$app->view->params['uid'];    
        $userInfo= ZfUser::findOne($uid);   
        $role_id = \yii::$app->view->params['role_id']; 
        $manageInfo=TeacherClass::getSchoolInfo($uid);
        $model=new BindForm;
        if ($model->load(Yii::$app->request->post()) && $model->bind($uid)) {
             echo "<script>alert('已提交申请，请耐心等待审核！');window.location='/teacher/myinfo';</script>";
        }else{
            return $this->render('myinfo',[
                   'userInfo'=>$userInfo,
                   'manageInfo'=>$manageInfo,
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
     * 校长取消绑定学校
     * @param type $id
     * @return type
     * @throws ForbiddenHttpException
     */
    public function actionDelschool($id){
        if(isset($id)){
           $res=TeacherClass::delclass($id);
        }else throw new ForbiddenHttpException('拒绝此操作.'); 
        if($res){
            \Yii::$app->session->setFlash("info", "取消成功");
            return $this->redirect(['myinfo']);
        }else  \Yii::$app->session->setFlash("info", "取消失败");
        
    }
    //所有教师
    public function actionAllteacher(){
        $uid=\yii::$app->view->params['uid'];
        $searchModel = new TeacherClassSearch();
        $sid=$searchModel::findAllTeachers($uid);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$sid);
        $model=new ApproveTeacher;
        if($model->load(Yii::$app->request->post()) && $model->approve()){
            return $this->redirect(['allteacher']);
        }else{
            return $this->render('allteacher',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model'=>$model
             ]);
        }
        
    }
    
    /**
     * Deletes an existing ZfTeacherClass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $res= ZfTeacherClass::findOne($id);
        if($res->delete()){
            return $this->redirect(['allteacher']);
        }       
    }
    
    /**
     * 班级列表
     * @return type
     */
    public function actionAllclass(){
        $sid=\yii::$app->view->params['sid'];
        $searchModel = new ClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$sid);
        $model=new ConfigTeacher;
        if($model->load(Yii::$app->request->post()) && $model->config($sid)){
            return $this->redirect(['allclass']);
        }else{
            return $this->render('allclass',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model'=>$model
            ]);
        }
        
    }
    /**
     * 班级考勤信息
     * @return type
     */
    public function actionSafeInfo(){
        $request =\yii::$app->request;
        $cid=($request->isPost)?$request->post('id'):$request->get('id');  
        $classname=($request->isPost)?$request->post('class'):$request->get('class');
        $date=\yii::$app->request->post('date');
        $time=strtotime($date);
        $safeinfo= SafeCardSearch::findCidSafeInfo($cid,$time);
        return $this->render('safe-info',[
            'cid'=>$cid,
            'data'=>$safeinfo['data'],
            'pagination'=>$safeinfo['pagination'],
            'classname'=>$classname
        ]);
    }
    /**
     * 班级请假信息
     */
    public function actionLeave(){
        $request =\yii::$app->request;
        $cid=($request->isPost)?$request->post('id'):$request->get('id');  
        $classname=($request->isPost)?$request->post('class'):$request->get('class');
        $leaveinfo= SafeCardSearch::findCidLeaveInfo($cid);
        return $this->render('leave',[
            'cid'=>$cid,
            'data'=>$leaveinfo['data'],
            'pagination'=>$leaveinfo['pagination'],
            'classname'=>$classname
        ]);
    }
    /**
     * 考勤明细及导出
     */
    public function actionSafecard(){
        $sid=\yii::$app->view->params['sid']; 
        $searchModel = new SafeCardSearch();
        $arr_stu=$searchModel::SchoolAllStudents($sid);
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
    

    
    /**
     * 删除公告
     */
    public function actionDelNotice($id){
        if(isset($id)){
            $notice=ZfNotice::findOne($id);
            $res=$notice->delete();
        }else throw new ForbiddenHttpException('拒绝此操作.');
        if($res){
            return $this->redirect(['schnotice']);
        }
    }
    
    /**
     * 发布和编辑公告
     */
    public function  actionAddNotice($id=null){       
        $model = new Notice();
        $sid=\yii::$app->view->params['sid'];
        $uid=\yii::$app->view->params['uid'];
        if(isset($id)){
            $data=Notice::find()->where(['id'=>$id])->asArray()->one();
        }
        if ($model->load(Yii::$app->request->post()) && $model->fabu($sid,$uid,$id)) {
            return $this->redirect(['schnotice']);
        }
        return $this->render('add-notice', [
            'model' => $model,
            'data'=>$data
        ]);
    }
    

    /**
     * 删除动态
     */
    public function actionDelNews($id){
        if(isset($id)){
            $news=ZfNews::findOne($id);
            $res=$news->delete();
        }else throw new ForbiddenHttpException('拒绝此操作.');
        if($res){
            return $this->redirect(['schnews']);
        }
    }
    /**
     * 发布和编辑动态
     */
    public function  actionAddNews($id=null){       
        $model = new News();
        $sid=\yii::$app->view->params['sid'];
        $uid=\yii::$app->view->params['uid'];
        if(isset($id)){
            $data=News::find()->where(['id'=>$id])->asArray()->one();
        }
        if ($model->load(Yii::$app->request->post()) && $model->fabu($sid,$uid,$id)) {
            return $this->redirect(['schnews']);
        }
        return $this->render('add-news', [
            'model' => $model,
            'data'=>$data
        ]);
    }
    
    /**
     * 学校首页设置
     */
    public function actionHomepage(){
        $sid=\yii::$app->view->params['sid'];
        $model=new UploadForm;
        $allLunbo= ZfSlide::find()->where(['sid'=>$sid])->orderBy('created DESC')->limit(4)->asArray()->all();
        $allColumn= ZfColumn::find()->where(['sid'=>$sid])->orderBy('submitTime DESC')->asArray()->all();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload($sid)) {
               echo "<script>alert('上传成功！');window.location='/manage/homepage';</script>";
            }
        }else{
            return $this->render('homepage',[
                'model'=>$model,
                'sid'=>$sid,
                'allLunbo'=>$allLunbo,
                'allColumn'=>$allColumn
            ]);
        }       
    }
    /**
     * 首页轮播删除
     * @return type
     */
    public function actionDellunbo(){
        $lunbo_arr=\yii::$app->request->post('chk_value');
        $res=ZfSlide::deleteAll(['in','id',$lunbo_arr]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ($res) ? ['status'=>0]:['status'=>1];
    }
    /**
     * 首页栏目设置
     */
    public function actionAddcolumn(){
        if (Yii::$app->request->isAjax) {
            $name=\yii::$app->request->post('name');
            $sid=\yii::$app->view->params['sid'];
            $uid=\yii::$app->view->params['uid'];
            $res=ZfColumn::addColumn($name,$sid,$uid);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ($res) ? ['status'=>0]:['status'=>1];
        }else throw new ForbiddenHttpException('拒绝此操作.');
    }
    /**
     * 栏目删除
     */
    public function actionDelcolumn(){
        if (Yii::$app->request->isAjax) {
            $id=\yii::$app->request->post('id');
            $models=ZfColumn::findOne($id);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ($models->delete()) ? ['status'=>0]:['status'=>1];
        }else throw new ForbiddenHttpException('拒绝此操作.');
    }
    /**
     * 栏目名称修改
     */
    public function actionEditcolumn(){
        if (Yii::$app->request->isAjax) {
            $id=\yii::$app->request->post('id');
            $name=\yii::$app->request->post('name');
            $models=ZfColumn::findOne($id);
            $models->columnName=$name;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ($models->save(false)) ? ['status'=>0]:['status'=>1];
        }else throw new ForbiddenHttpException('拒绝此操作.');
    }
    /**
     * 栏目内容编辑
     */
    public function actionEditColcontent(){
        $id=\yii::$app->request->get('id');
        $data=ZfColumn::findOne($id);
        $model=new Column;        
        if (Yii::$app->request->isPost){
            $model->columnPicture = UploadedFile::getInstance($model, 'columnPicture');       
            if ($model->columnPicture ) { 
                  $model->upload($id);
            }
            $model->load(Yii::$app->request->post());
            if ($model->load(Yii::$app->request->post()) && $model->editcol($id)) {
                echo "<script>alert('发布成功！');window.location='/manage/network';</script>";
            }else{
                echo "<script>alert('标题和内容不能为空！');window.history.back();</script>";
            }
        }else{
            return $this->render('edit-colcontent',[
                'model'=>$model,
                'data'=>$data
            ]); 
        }   
        
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