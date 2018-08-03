<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-04-27
 * Time: 15:48
 */
namespace backend\controllers;

use backend\models\SchoolQuery;
use common\models\ZfClass;
use common\models\ZfSchool;
use \yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use Yii;
class QueryController extends BaseController
{
    public function actionIndex()
    {
        $this->viewPath = '@backend/views/query';
        \yii::$app->view->params['schoolid'] = 56744;
        $allSchoolInfo = SchoolQuery::getSchool(\Yii::$app->request->queryParams);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $allSchoolInfo,
            'key'=>"id"
        ]);
/*        $dataProvider2 = new ArrayDataProvider([
            'allModels' => SchoolQuery::gettongji(\Yii::$app->request->queryParams),
        ]);*/
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            $array_values =  [
                [
                    'attribute'=>'name',
                    'header'=>"学校名称",
                ],
                [
                    'attribute'=>'snum',
                    'header'=>"总人数",
                    'value'=>function($model){
                        return 	isset($model['snum'])?$model['snum']:"0";
                    }
                ],
                [
                    'attribute'=>'bnum',
                    'header'=>"绑定数",
                    'value'=>function($model){
                        return 	isset($model['bnum'])?$model['bnum']:"0";
                    }
                ],
                [
                    'attribute'=>'brate',
                    'header'=>"绑定率",
                    'format'=>['percent','2'],
                    'value'=>function($model){
                        return 	isset($model['brate'])?$model['brate']:"0";
                    }
                ],
                [
                    'attribute'=>'mnumpa',
                    'header'=>"平安通知缴费数量",
                    'value'=>function($model){
                        return 	isset($model['mnumpa'])?$model['mnumpa']:"0";
                    }
                ],
                [
                    'attribute'=>'mratepa',
                    'header'=>"平安通知缴费率",
                    'format'=>['percent','2'],
                    'value'=>function($model){
                        return 	isset($model['mratepa'])?$model['mratepa']:"0";
                    }
                ],
                [
                    'attribute'=>'mnumjx',
                    'header'=>"家校沟通缴费数量",
                    'value'=>function($model){
                        return 	isset($model['mnumjx'])?$model['mnumjx']:"0";
                    }
                ],
                [
                    'attribute'=>'mratejx',
                    'header'=>"家校沟通缴费率",
                    'format'=>['percent','2'],
                    'value'=>function($model){
                        return 	isset($model['mratejx'])?$model['mratejx']:"0";
                    }
                ],
                [
                    'attribute'=>'mnumqq',
                    'header'=>"亲情电话缴费数量",
                    'value'=>function($model){
                        return 	isset($model['mnumqq'])?$model['mnumqq']:"0";
                    }
                ],
                [
                    'attribute'=>'mrateqq',
                    'header'=>"亲情电话缴费率",
                    'format'=>['percent','2'],
                    'value'=>function($model){
                        return 	isset($model['mrateqq'])?$model['mrateqq']:"0";
                    }
                ],
                [
                    'attribute'=>'mnumck',
                    'header'=>"餐卡缴费数量",
                    'value'=>function($model){
                        return 	isset($model['mnumck'])?$model['mnumck']:"0";
                    }
                ],
                [
                    'attribute'=>'mrateck',
                    'header'=>"餐卡缴费率",
                    'format'=>['percent','2'],
                    'value'=>function($model){
                        return 	isset($model['mrateck'])?$model['mrateck']:"0";
                    }
                ],
                [
                    'attribute'=>'cnum',
                    'header'=>"平安卡使用数量",
                    'value'=>function($model){
                        return 	isset($model['cnum'])?$model['cnum']:"0";
                    }
                ],
                [
                    'attribute'=>'crate',
                    'header'=>"使用率",
                    'format'=>['percent','2'],
                    'value'=>function($model){
                        return 	isset($model['crate'])?$model['crate']:"0";
                    }
                ],
            ];
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
//                'models2' => $dataProvider2->allModels,
                'columns' => $array_values,
                'fileName' => "all.xlsx"
            ]);
        }else
            return $this->render('index', [
                'dataProvider' => $dataProvider,
//                'dataProvider2' => $dataProvider2,
                'dateInfo' => \Yii::$app->request->queryParams
            ]);


    }

    //本校班级
    public function actionClass($sid)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => SchoolQuery::getClass($sid),
            "key"=>"id"
        ]);
        $array_values = [
            [
                'attribute'=>'name',
                'header'=>"班级"
            ],
            [
                'attribute'=>'cnum',
                'header'=>"班级总人数"
            ],
            [
                'attribute'=>'bnum',
                'header'=>"绑定数量"
            ],
            [
                'attribute'=>'brate',
                'header'=>"绑定率",
                'format'=>['percent','2']
            ],
            [
                'attribute'=>'mnumpa',
                'header'=>"平安通知缴费数量"
            ],
            [
                'attribute'=>'mratepa',
                'header'=>"平安通知缴费率",
                'format'=>['percent','2'],
            ],
            [
                'attribute'=>'mnumjx',
                'header'=>"家校沟通缴费数量"
            ],
            [
                'attribute'=>'mratejx',
                'header'=>"家校沟通缴费率",
                'format'=>['percent','2'],
            ],
            [
                'attribute'=>'mnumqq',
                'header'=>"亲情电话缴费数量"
            ],
            [
                'attribute'=>'mrateqq',
                'header'=>"亲情电话缴费率",
                'format'=>['percent','2'],
            ],
            [
                'attribute'=>'mnumck',
                'header'=>"餐卡缴费数量"
            ],
            [
                'attribute'=>'mrateck',
                'header'=>"餐卡缴费率",
                'format'=>['percent','2'],
            ],
            [
                'attribute'=>'dnum',
                'header'=>"平安通知数量"
            ],
            [
                'attribute'=>'drate',
                'header'=>"使用率",
                'format'=>['percent','2'],
            ],
        ];
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
                'columns' => $array_values,
                'fileName' => "local-school.xlsx"
            ]);
        }else
            return $this->render('class', [
                'dataProvider' => $dataProvider,
                'array_columns' => $array_values
            ]);
    }

    public function actionSafecard($sid)
    {
        $classname = $this->classname;
        Yii::trace($this->classname);
        $dataProvider = new ArrayDataProvider([
            'allModels' => SchoolQuery::getSafecard($sid),
            'key' => "id"
        ]);

        $array_values = [
            [
                'attribute'=>'name',
                'header'=>"学校名称"
             ],
            [
                'attribute'=>'class',
                'header'=>"班级名称",
                'value'=>function($model) use ($classname){
                    return $classname[$model['class']]?$classname[$model['class']]:"";
                }
            ],
            [
                'attribute'=>'stuName',
                'header'=>"学生姓名"
            ],
            [
                'attribute'=>'ctime',
                'header'=>"刷卡时间",
                'value'=>function($model){
                    return $model['ctime']?date("Y-m-d H:i:s",$model['ctime']):"";
                }
            ],
            [
                'attribute'=>'info',
                'header'=>"状态",
                'value'=>function($model){
                    return $model['info']?:"";
                }
            ]];
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
                'columns' => $array_values,
                'fileName' => "local-school.xlsx"
            ]);
        }else
            return $this->render('safecard', [
                'dataProvider' => $dataProvider,
                'array_columns' =>$array_values
            ]);
    }

    public function actionFee($sid)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => SchoolQuery::getFee($sid),
            'key' => "id"
        ]);
        $classname = $this->classname;
        $array_values = [
            [
                'attribute'=>'name',
                'header'=>"学校名称"
            ],
            [
                'attribute'=>'class',
                'header'=>"班级名称",
                'value'=>function($model) use ($classname){
                    return $classname[$model['class']]?$classname[$model['class']]:"";
                }
            ],
            [
                'attribute'=>'stuName',
                'header'=>"学生姓名"
            ],
            [
                'attribute'=>'upendtimepa',
//                //                'format'=>"datetime",
                'header'=>"平安通知缴费时间"
            ],
            [
                'attribute'=>'enddatepa',
                //                'format'=>"datetime",
                'header'=>"平安通知有效期"
            ],
            [
                'attribute'=>'upendtimejx',
                //                'format'=>"datetime",
                'header'=>"家校沟通缴费时间"
            ],
            [
                'attribute'=>'enddatejx',
                //                'format'=>"datetime",
                'header'=>"家校沟通有效期"
            ],
            [
                'attribute'=>'upendtimeqq',
                //                'format'=>"datetime",
                'header'=>"亲情电话缴费时间"
            ],
            [
                'attribute'=>'enddateqq',
                //                'format'=>"datetime",
                'header'=>"亲情电话有效期"
            ],
            [
                'attribute'=>'upendtimeck',
                //                'format'=>"datetime",
                'header'=>"餐卡缴费时间"
            ],
            [
                'attribute'=>'enddateck',
                //                'format'=>"datetime",
                'header'=>"餐卡有效期"
            ]
        ];

        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
                'columns' => $array_values,
                'fileName' => "local-fee.xlsx"
            ]);
        }else
            return $this->render('fee', [
                'dataProvider' => $dataProvider,
                'array_columns' =>$array_values
            ]);
    }
    public function actionBind($sid)
    {
        $classname = $this->classname;
        $array_values = [
            [
                'attribute'=>'name',
                'header'=>"学校名称"
            ],
            [
                'attribute'=>'stuno',
                'header'=>"学号"
            ],
            [
                'attribute'=>'stu_name',
                'header'=>"学生姓名"
            ],
            [
                'attribute'=>'class_id',
                'header'=>"班级",
                'value'=>function($model) use ($classname){
                    return $classname[$model['class_id']]?$classname[$model['class_id']]:"";
                }
            ]
        ];
        $dataProvider = new ArrayDataProvider([
            'allModels' => SchoolQuery::getBind($sid),
            'key' => "id"
        ]);
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
                'columns' => $array_values,
                'fileName' => "local-bind.xlsx"
            ]);
        }else
            return $this->render('bind', [
                'dataProvider' => $dataProvider,
                'array_columns' => $array_values
            ]);
    }


    public function actionConnect($sid)
    {
        $classname = $this->classname;
        $schoolname = $this->schoolname;
        $username = $this->username;
        $stuname = $this->stuname;
        $array_values = [
            [
                'attribute'=>'sid',
                'header'=>"学校名称",
                'value'=>function($model) use ($schoolname){
                    return $schoolname[$model['sid']]?$schoolname[$model['sid']]:"";
                }
            ],
            [
                'attribute'=>'class_id',
                'header'=>"班级",
                'value'=>function($model) use ($classname){
                    return $classname[$model['class_id']]?$classname[$model['class_id']]:"";
                }
            ],
            [
                'attribute'=>'out_uid',
                'header'=>"发件人",
                'value'=>function($model) use ($username){
                    return $username[$model['out_uid']]?$username[$model['out_uid']]:"";
                }
            ],
            [
                'attribute'=>'stuName',
                'header'=>"学生姓名",
                'value'=>function($model) use ($stuname){
                    return $stuname[$model['stuName']]?$stuname[$model['stuName']]:"";
                }
            ],
            [
                'attribute'=>'sendNum',
                'header'=>"发送数量"
            ]
        ];
        $dataProvider = new ArrayDataProvider([
            'allModels' => SchoolQuery::getConnect($sid)
        ]);
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
                'columns' => $array_values,
                'fileName' => "local-connect.xlsx"
            ]);
        }else
            return $this->render('connect', [
                'dataProvider' => $dataProvider,
                'array_columns' => $array_values
            ]);
    }

//    分类信息查询
    public function actionWbdrs()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => SchoolQuery::getWeibangding(\Yii::$app->request->queryParams),
            'key'=>"id"
        ]);
//	var_dump($dataProvider);exit();
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export")
        {
            $array_values =  [
                [
                    'attribute'=>'id',
                    'header'=>"学生ID",
                ],
                [
                    'attribute'=>'name',
                    'header'=>"学生姓名",
                ],
                [
                    'attribute'=>'class',
                    'header'=>"班级",
                ],
                [
                    'attribute'=>'school',
                    'header'=>"学校名字",
                ],
            ];
            \moonland\phpexcel\Excel::export([
                'models' => $dataProvider->allModels,
                'columns' => $array_values,
                'fileName' => "all.xlsx"
            ]);
        }else
            return $this->render('wbdrs', [
                'dataProvider' => $dataProvider,
                'dateInfo' => \Yii::$app->request->queryParams
            ]);
    }

    /**
    新平安通知设备状态
     **/
    public function actionNewsbzt(){
/*        $redis = BaseController::getRedis();
        try {
            $redis->ping();
        } catch (Exception $e) {
            $redis = UtilsController::getRedis();
        }
        $redis->select(15);
        $rediskey = $redis->keys('*');*/
        // var_dump($rediskey);exit;
        $sql = "select id,name,pinganid from zf_school where pinganid is not null and id not in(56731,56683)";
        $row2 = $row = Yii::$app->db->createCommand($sql)->queryAll();
         $rediskey = array('5677521','5662301','5665201','5665301','5668401','5676201','5675811','5675711','5674001','5668101','5669801','5673911','5674201','5665401','5673811','5675712','5675901','5667501','5667001','5665004','5675713','5666501','5673802','5675912','5666601','5675801','5665011','5666401','5665003','5670701','5664901','5665013','5673201','5665001','5665012','5674401','5673901','5668201');
        $i=0;
        foreach ($row as $key => $value) {
            foreach ($rediskey as $k => $v) {
                if(substr($v,0,5) == $value['id']){
                    if(strlen($v) == 5){                //暂未位置信息
                        $new['zcmwz'][$value['id']]['sid'] = $value['id'];
                        $new['zcmwz'][$value['id']]['sname'] = $value['name'];
//                      $new['zcmwz'][$value['id']]['pingan_id'][$i] = substr($v,5,2);
                    }else{
                        $new['zc'][$value['id']]['sid'] = $value['id'];
                        $new['zc'][$value['id']]['sname'] = $value['name'];
                        $new['zc'][$value['id']]['pingan_id'][$i] = substr($v,5,2);
                    }
                    unset($row[$key]);
                }
                $i++;
            }
        }

        foreach ($new['zc'] as $k => $v) {
            foreach ($row2 as $key => $value) {
                $num = count(json_decode($value["pinganid"],true));
                if (intval($value['id']) == $k) {
                    if($num != count($v["pingan_id"])){
                        $new['bfzc'][$k] = $new['zc'][$k];
                        unset($new['zc'][$k]);
                        $bfbzc = array_diff(json_decode($value["pinganid"],true),$v["pingan_id"]); //部分正常不正常部分
                        $bfzc = array_intersect(json_decode($value["pinganid"],true),$v["pingan_id"]); //部分正常正常部分
                        $new['bfzc'][$k]['pingan_bzcid'] = $bfbzc;
                        $new['bfzc'][$k]['pingan_zcid'] = $bfzc;
                    }else{
                        $new['zc'][$k]['pingan_zcid'] = json_decode($value["pinganid"],true);
                    }
                }
            }
        }
        // echo "<pre>";
        // var_dump($new['zc']);//全部正常
        // var_dump($row);//全不正常
        // var_dump($new['bfzc']);//部分正常
        // exit();

        // $bzcxx =json_decode($row[23]["pinganid"],true);     var_dump($bzcxx);exit();
//      $bzcxx = json_decode($value['pinganid'],true);
        return $this->render('newsbzt',[
            'bzc' => $row,
            'zc' => $new
        ]);
    }

    //平安通知汇总查询信息
    public function actionNewsbxx(){
        $params = \Yii::$app->request->queryParams;
        $from_unix_time = 0;
        $to_unix_time = "2038-1-19";
        if(isset($params['from_date']) && isset($params['to_date']))
        {
            $from_unix_time = $params['from_date'];
            $to_unix_time = $params['to_date'];
        }
        yii::trace($from_unix_time);
        yii::trace($to_unix_time);
        $sql = "select tmp.*,tmp2.* FROM 
(select p.sid,COUNT(p.ctime)AS zcs,p.pa_id,p.pa_name FROM zf_pasb p WHERE p.ctime BETWEEN :from_unix_time AND :to_unix_time GROUP BY p.sid,p.pa_id) tmp LEFT JOIN
 (select s.pa_id pa_id2,s.sid sid2,COUNT(s.pa_id) zccs from zf_pasb s where s.status = 0 and s.ctime BETWEEN :from_unix_time AND :to_unix_time GROUP BY s.pa_id,s.sid) tmp2 ON 
 tmp.pa_id=tmp2.pa_id2 AND tmp.sid=tmp2.sid2  ORDER BY tmp.sid,tmp.pa_id";
        $row = Yii::$app->db->createCommand($sql,[':from_unix_time'=>$from_unix_time,'to_unix_time'=>$to_unix_time])->queryAll();
        $new = array();
        foreach($row as $k=>$v){
            $new[$v['sid']]['sid'] = $v['sid'];
            $new[$v['sid']]['school'] = self::getSname($v['sid']);
            Yii::trace($new[$v['sid']]['school']);
//            $new[$v['sid']]['zcs'] = $v['zcs'];
            $new[$v['sid']]['sbxx'][$k]['zcs'] = $v['zcs'];
            $new[$v['sid']]['sbxx'][$k]['zccs'] = $v['zccs'];
            $new[$v['sid']]['sbxx'][$k]['pa_name'] = $v['pa_name'];
        }
//        echo "<pre>";
//        var_dump($new);exit();
        return $this->render('newsbxx',[
            'new' => $new,
            'dateInfo' => \Yii::$app->request->queryParams
        ]);
    }

    //根据学校ID获取学校名字
    private function getSname($id){
        $model = ZfSchool::findOne($id)->name;
        $sname = isset($model)?$model:"暂时没该学校";
        return $sname;
    }

    /**
    新亲情电话设备状态
     **/
    public function actionNewqqzt(){
        $sql = "select DISTINCT(sid) FROM zf_telephone";
        $row = Yii::$app->db->createCommand($sql)->queryColumn();
        $sql2 = "select Device_id,AddressInfo,sid from zf_telephone ORDER BY sid,Device_id";
        $row2 = Yii::$app->db->createCommand($sql2)->queryAll();
/*        $redis = BaseController::getRedis();
        try {
            $redis->ping();
        } catch (Exception $e) {
            $redis = UtilsController::getRedis();
        }
        $redis->select(14);
        $rediskey = $redis->keys('*');*/

        $rediskey = array('000000567440001','000000567440002','000000567440003','000000567440004');
        $i=0;
        $new = array();
        foreach ($row as $key => $value) {
            foreach ($rediskey as $k => $v) {
                if(substr($v,6,5) == $value){
                    $new['zc'][$value]['sid'] = $value;
                    $new['zc'][$value]['sname'] = $this->getSname($value);
                    $new['zc'][$value]['pingan_id'][$i] = intval(substr($v,11,4));
                    unset($row[$key]);
                }
                $i++;
            }
        }

        foreach($row2 as $k => $v){
            $newrow[$v['sid']]['id'] = $v['sid'];
            $newrow[$v['sid']]['pinganid'][$k] = intval(substr($v['Device_id'],11,4));
        }
        if (isset($new['zc'])){
            foreach ($new['zc'] as $k => $v) {
                foreach ($newrow as $key => $value) {
                    $num = count($value["pinganid"],true);
                    if (intval($value['id']) == $k) {
                        if($num != count($v["pingan_id"])){
                            $new['bfzc'][$k] = $new['zc'][$k];
                            unset($new['zc'][$k]);
                            $bfbzc = array_diff($value["pinganid"],$v["pingan_id"]); //部分正常不正常部分
                            $bfzc = array_intersect($value["pinganid"],$v["pingan_id"]); //部分正常正常部分
                            $new['bfzc'][$k]['pingan_bzcid'] = $bfbzc;
                            $new['bfzc'][$k]['pingan_zcid'] = $bfzc;
                        }
                    }
                }
            }
        }
        $new['qbzc'] = [];
        if(isset($row)){
            foreach ($row as $k => $v) {
                foreach ($newrow as $key => $value) {
                    $num = count($value["pinganid"],true);
                    if ($v == $value['id']) {
                        $bzc[$v] = $this->getSname($v);
                        $new['qbzc'][$v]['sid'] = $v;
                        $new['qbzc'][$v]['sname'] = $this->getSname($v);;
                        $new['qbzc'][$v]['pingan_bzcid'] = $value["pinganid"];
                    }
                }
            }
        }
//      echo "<pre>";
//      var_dump($new['zc']);//全部正常
//       var_dump($new['qbzc']);//全不正常
//       var_dump($new['bfzc']);//部分正常
//      var_dump($bzc);
//      exit();
//      var_dump($row);exit();
        return $this->render('newqqzt',[
            'bzc' => $new['qbzc'],
            'zc' => $new
        ]);
    }

    //亲情电话汇总查询信息
    public function actionNewqqxx(){
        $params = \Yii::$app->request->queryParams;
        $from_unix_time = 0;
        $to_unix_time = "2038-1-19";
        if(isset($params['from_date']) && isset($params['to_date']))
        {
            $from_unix_time = $params['from_date'];
            $to_unix_time = $params['to_date'];
        }
        $sql = "select tmp.*,tmp2.* FROM 
(select p.sid,COUNT(p.ctime)AS zcs,p.pa_id,p.pa_name FROM zf_qqsb p WHERE p.ctime BETWEEN :from_unix_time AND :to_unix_time GROUP BY p.sid,p.pa_id) tmp LEFT JOIN
 (select s.pa_id pa_id2,s.sid sid2,COUNT(s.pa_id) zccs from zf_qqsb s where s.status = 0 and s.ctime BETWEEN :from_unix_time AND :to_unix_time GROUP BY s.pa_id,s.sid) tmp2 ON 
 tmp.pa_id=tmp2.pa_id2 AND tmp.sid=tmp2.sid2  ORDER BY tmp.sid,tmp.pa_id ASC ";
        $row = Yii::$app->db->createCommand($sql,[':from_unix_time'=>$from_unix_time,'to_unix_time'=>$to_unix_time])->queryAll();
        $new = array();
        foreach($row as $k=>$v){
            $new[$v['sid']]['sid'] = $v['sid'];
            $new[$v['sid']]['school'] = $this->getSname($v['sid']);
//            $new[$v['sid']]['zcs'] = $v['zcs'];
            $new[$v['sid']]['sbxx'][$k]['zcs'] = $v['zcs'];
            $new[$v['sid']]['sbxx'][$k]['zccs'] = $v['zccs'];
            $new[$v['sid']]['sbxx'][$k]['pa_name'] = $v['pa_name'];
        }
//        echo "<pre>";
//        var_dump($row);exit();
        return $this->render('newqqxx',[
            'new' => $new,
            'dateInfo' => \Yii::$app->request->queryParams
        ]);
    }

}