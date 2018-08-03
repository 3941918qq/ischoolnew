<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use frontend\models\BaseData;
use common\models\ZfCity;
use common\models\ZfCounty;
use common\models\ZfClass;
use common\models\ZfSchool;
use common\models\ZfNotice;
use common\models\ZfNews;
use common\models\ZfRole;
use common\models\ZfColumn;
use frontend\models\ChangePwd;
/**
 * Index controller
 */
class BaseController extends  Controller{

    public function init(){
        parent::init();
        $session = \Yii::$app->session;      
        $uid = $session->get('uid');
        $lifetime = $session->get('lifetime');
        if(!$uid || $lifetime<time()){
            return $this->redirect(['/index/login']);
        }
        $role_id = $session->get('role_id');
        if(!$role_id){
            $role_id=BaseData::getRoleid($uid);           
            $session->set('role_id',$role_id);          
        }
        $sid=BaseData::getSid($uid);
        \yii::$app->view->params['role_id'] = $role_id;
        \yii::$app->view->params['uid'] = $uid;
        \yii::$app->view->params['sid'] = $sid;
    }
    public function behaviors(){
        return [
//            'pageCache'=>[
//                'class' => 'yii\filters\PageCache',
//                'only' => ['schnotice','schnews'],
//                'duration' => 3600,
//                'variations' => [
//                    \yii::$app->request->get('page'),
//                    \yii::$app->view->params['sid'],
//                ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT COUNT(*) FROM zf_notice',
//                ],
//            ],
//            'httpCache'=>[
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['notice-detail'],
//                'lastModified' => function ($action, $params) {
//                    $q = new \yii\db\Query();
//                    return $q->from('zf_notice')->max('submitTime');
//                },
//            ],
        ];
    }
    //身份校验
    public function checkRole($role_id){
        $models=ZfRole::findOne($role_id);
        return $models['name'];
    }
    public function a($info){
        echo '<pre>';
        var_dump($info);die;
    }
    
    public function FormatJson($info){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'message' =>$info,
        ];
    }
    //联动城市
    public function actionCitys() {
        $prov_paramers = \yii::$app->request->post('depdrop_all_params');
    	if(!$prov_paramers || !isset($prov_paramers['pro-id'])) exit();
    	$prov_id = $prov_paramers['pro-id'];
    	$citys_cache = \yii::$app->cache->get("province_".$prov_id);
    	if(true || !$citys_cache)
    	{
    		$citys_cache = [];
    		$citys_info =  ZfCity::find()->select(['id','name'])->where(['pro_id'=>$prov_id])->asArray()->all();
    		\yii::$app->cache->set("province_".$prov_id,$citys_cache);
    	}
    	return json_encode(["output"=>$citys_info]);
    }
    //联动县区
    public function actionCountys() {
        $city_paramers = \yii::$app->request->post('depdrop_all_params');
    	if(!$city_paramers || !isset($city_paramers['city-id'])) exit();
    	$city_id = $city_paramers['city-id'];
    	$citys_cache = \yii::$app->cache->get("city_".$city_id);
    	if(true || !$countys_cache)
    	{
    		$countys_cache = [];
    		$countys_info =  ZfCounty::find()->select(['id','name'])->where(['city_id'=>$city_id])->asArray()->all();
    		\yii::$app->cache->set("city_".$city_id,$countys_cache);
    	}
    	return json_encode(["output"=>$countys_info]);
    }
    //联动学校
    public function actionSchools() {
        $county_paramers = \yii::$app->request->post('depdrop_all_params');
    	if(!$county_paramers || !isset($county_paramers['county-id'])) exit();
    	$county_id = $county_paramers['county-id'];
    	$county_cache = \yii::$app->cache->get("county_".$county_id);
    	if(true || !$school_cache)
    	{
    		$school_cache = [];
    		$school_info =  ZfSchool::find()->select(['id','name'])->where(['county_id'=>$county_id])->asArray()->all();
    		\yii::$app->cache->set("county_".$county_id,$county_cache);
    	}
    	return json_encode(["output"=>$school_info]);
    }
    //联动班级
    public function actionClass() {
        $school_paramers = \yii::$app->request->post('depdrop_all_params');
    	if(!$school_paramers || !isset($school_paramers['school-id'])) exit();
    	$school_id = $school_paramers['school-id'];
    	$school_cache = \yii::$app->cache->get("school_".$school_id);
    	if(true || !$class_cache)
    	{
    		$class_cache = [];
    		$class_info =  ZfClass::find()->select(['id','name'])->where(['sid'=>$school_id])->asArray()->all();
    		\yii::$app->cache->set("school_".$school_id,$class_cache);
    	}
    	return json_encode(["output"=>$class_info]);
    }
    /**
     * 密码修改
     * @return type
     */
    public function actionChangepass(){
        $model=new ChangePwd;
        if ($model->load(Yii::$app->request->post()) && $model->check()) {
             echo "<script>alert('修改成功！');window.location='/teacher/changepass';</script>";
        } else {
            return $this->render('changepass',[
                'model'=>$model
            ]);
        }
        
    }
     /*
     * 校内公告
     */
    public function actionSchnotice(){
        $sid=\yii::$app->view->params['sid'];
        //获取该校所有公告信息
        $query =ZfNotice::find()->where(['sid'=>$sid]); 
        $dataProvider = new ActiveDataProvider([  
            'query' => $query,  
            'pagination' => [  
                'pageSize' => 10,  
            ],  
            'sort' => [
                'defaultOrder' => [
                    'submitTime' => SORT_DESC,
                ]
            ],
        ]); 
        return $this->render('schnotice',[
            'dataProvider' => $dataProvider 
        ]);
    }
    /**
     * 公告详情
     */
    public function actionNoticeDetail($id){
        if(isset($id)){
            $noticeDetail=ZfNotice::findOne($id);
        }else throw new ForbiddenHttpException('拒绝此操作.');
        sleep(3);
        return $this->render('notice-detail',[
            'noticeDetail'=>$noticeDetail,
        ]);
    }
    /*
     * 校内动态
     */
    public function actionSchnews(){
        $sid=\yii::$app->view->params['sid'];
        //获取该校所有公告信息
        $query =ZfNews::find()->where(['sid'=>$sid]); 
        $dataProvider = new ActiveDataProvider([  
            'query' => $query,  
            'pagination' => [  
                'pageSize' => 10,  
            ],  
            'sort' => [
                'defaultOrder' => [
                    'submitTime' => SORT_DESC,
                ]
            ],
        ]); 
        return $this->render('schnews',[
            'dataProvider' => $dataProvider 
        ]);
    }
    /**
     * 动态详情
     */
    public function actionNewsDetail($id){
        if(isset($id)){
            $newsDetail=ZfNews::findOne($id);
        }else throw new ForbiddenHttpException('拒绝此操作.');
        return $this->render('news-detail',[
            'newsDetail'=>$newsDetail,
        ]);
    }
    /**
     * 微官网首页
     * @return type
     */
    public function actionNetwork(){
        //获取最新公告，班级动态
        $sid=\yii::$app->view->params['sid'];
        $data = BaseData::findNewNoticeNews($sid);
        return $this->render('network',[
            'notice'=>$data['notice'],
            'news'=>$data['news'],
            'column'=>$data['column'],
            'school'=>$data['school'],
            'slide'=>$data['slide']
        ]);
    }
    /**
     * 栏目内容详情
     */
    public function actionColumnDetail($id){
        if($id){
            $info=ZfColumn::findOne($id);
        } else throw new ForbiddenHttpException('拒绝此操作.');
        return $this->render('column-detail',[
            'info'=>$info
        ]); 
    }
}

