<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UserLogin;
use frontend\models\UserRegister;
use common\models\ZfUser;
use frontend\models\User;
/**
 * Index controller
 */
class IndexController extends Controller{
    public $layout='index';
    //登录
    public  function actionLogin(){ 
        $model = new UserLogin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    //退出
    public function actionLogout(){
        $session = Yii::$app->session;
        $session->destroy();
        return $this->redirect(['login']);
    }
    //用户注册
    public function actionRegister(){
        $model = new UserRegister();    
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                echo "<script>alert('注册成功,请登录！');window.location='/index/login';</script>";
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }   
    //找回密码
    public function actionFindpass(){
        $model = new ZfUser();
        $tel = Yii::$app->request->post('userPhonwj');
        $res = $model->findOne(['tel'=>$tel]);
        if(!empty($res)) {
            echo "<script>alert('该功能暂未完成！');window.location='/index/login';</script>";
        }else{
            echo "<script>alert('该手机号码尚未注册！');window.location='/index/login';</script>";
        }
    }
    //切换身份角色
    public function actionToggleRole(){
       $role_id= \yii::$app->request->post('role');
       $uid=\yii::$app->request->post('uid');
       $result_url=User::toggleRole($role_id,$uid);
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       if($result_url){
           $status='0';
           $url='/'.$result_url.'/myinfo';
       }
       return [
            'status' =>$status,
            'url' =>$url,
       ];
    }

    //切换
    public function actionToggle(){
        $post=\yii::$app->request->post();
        $result_url=User::toggle($post);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($result_url){
            $status='0';
        }
        return [
             'status' =>$status,
        ];
    }
}