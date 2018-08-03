<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-04-28
 * Time: 14:50
 */
namespace backend\controllers;
use Yii;
use common\models\BaseModel;
use yii\base\Controller;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use common\models\ZfCity;
use common\models\ZfCounty;
use common\models\ZfClass;
use yii\filters\VerbFilter;
class BaseController extends \yii\web\Controller
{
    public $basemodel;
    public $classname;
    public $schoolname;
    public $username;
    public $stuname;
    public function init()
    {
        parent::init();
        $this->basemodel = new BaseModel();
        $this->classname = $this->getClassName();
        $this->schoolname = $this->getSchoolName();
        $this->username = $this->getUserName();
        $this->stuname = $this->getStuName();
    }

    public function beforeAction($action){
        // $this->viewPath = '@backend/views/school';
        if (Yii::$app->user->isGuest) return $this->redirect("/user/login")->send();
        if (parent::beforeAction($action)) {
            $permission = \yii::$app->controller->route;
            if (Yii::$app->user->can($permission)) {
                return true;
            }
            else
                throw new ForbiddenHttpException();
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function getClassName()
    {
        $info =  $this->basemodel->getClassInfo();
        return ArrayHelper::map($info, "id", "name");
    }
    public function getSchoolName()
    {
        $info =  $this->basemodel->getSchoolInfo();
        return ArrayHelper::map($info, "id", "name");
    }
    public function getUserName()
    {
        $info =  $this->basemodel->getUserInfo();
        return ArrayHelper::map($info, "id", "name");
    }
    public function getStuName()
    {
        $info =  $this->basemodel->getStuInfo();
        return ArrayHelper::map($info, "id", "name");
    }

    /**
    *连接redis
     */
    public static function getRedis(){
        $redis = new \redis();
        $redis->connect('127.0.0.1',6379,5); //本机6379端口，5秒超时
        $redis->select(13);      //13库短信验证码存放
        return $redis;
    }
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

}