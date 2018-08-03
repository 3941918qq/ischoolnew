<?php

namespace backend\controllers;

use Yii;
use common\models\ZfStudents;
use common\models\ZfStudentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use common\models\ZfFamilyNumber;
/**
 * StudentController implements the CRUD actions for ZfStudents model.
 */
class StudentController extends BaseController
{
    /**
     * Lists all ZfStudents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZfStudentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export"){
            foreach($dataProvider->getModels() as $t){
                 $arr[] = $t->attributes;
            }
            $array=$searchModel->getInfo($arr);
            $array_values =[
                'id' => 'ID',
                'name' => '姓名',
                'stu_no' => '学号',
                'class' => '班级',
                'school' => "学校",
                'epc_no' => 'EPC',
                'tel_no' => '电话卡',
                'enddatejx' => '家校沟通有效期',
                'enddateqq' => '亲情电话有效期',
                'enddateck' => '餐卡有效期',
                'enddatepa' => '平安通知有效期'              
            ];
            $array_keys = array_keys($array_values);
            \moonland\phpexcel\Excel::export([
                    'models' => $array,
                    'columns' => $array_keys, 
                    'headers' => $array_values,
                    'fileName' => "student.xlsx"
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ZfStudents model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ZfStudents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZfStudents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZfStudents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ZfStudents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ZfStudents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZfStudents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZfStudents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * 绑定亲情号页面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionBind($id)
    {
        $model = $this->findModel($id);
        $parents = ZfFamilyNumber::getParents($id);
        return $this->render('bind', [
                'model' => $model,
                'parents' => $parents
        ]);
        
    }
    /**
     * 保存亲情号
     * @return [type] [description]
     */
    public function actionAjaxsave(){
        $post_params = \yii::$app->request->post();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result=ZfFamilyNumber::saveQqtel($post_params);
        return $result;      
    }

    /**
     * 删除亲情号
     */
    public function actionAjaxdelete(){
        $post_params = \yii::$app->request->get();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result=ZfFamilyNumber::delQqtel($post_params);
        return $result;
    }
    
        //批量更新页面
        public function actionBatchedit()
        {
            $params = \yii::$app->request->get();
            \Yii::trace(\yii::$app->request->get());
            $querystring = \yii::$app->request->queryString;
            \Yii::trace($querystring);
            return $this->render("batchedit",[
                    "querystring"=>$querystring,
                    "params" => $params

            ]);
        }
        public function actionBatchupdate() {
    	    $searchModel = new ZfStudentsSearch();
	    $searchModel->batchUpdate(Yii::$app->request->queryParams,yii::$app->request->post('enddatepa'),yii::$app->request->post('enddateqq'),yii::$app->request->post('enddatejx'),yii::$app->request->post('enddateck'));
    	    return $this->redirect("/student/index");
    	
    }
}
