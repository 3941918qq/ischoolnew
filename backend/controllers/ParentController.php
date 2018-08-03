<?php

namespace backend\controllers;

use Yii;
use common\models\ZfParentStudent;
use common\models\ZfParentStudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
/**
 * ParentController implements the CRUD actions for ZfParentStudent model.
 */
class ParentController extends BaseController
{
    /**
     * Lists all ZfParentStudent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZfParentStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export"){
            foreach($dataProvider->getModels() as $t){
                 $arr[] = $t->attributes;
            }
            $array=$searchModel->getInfo($arr);
            $array_values =[
                'id'=>'ID',
                'name' => '姓名',
                'tel' => '电话',
                'stu_name' => '学生姓名',
                'stu_id' => '学生ID',
                'class' => '班级',
                'class_id' => '班级ID',
                'school'=>'学校'
            ];
            $array_keys = array_keys($array_values);
            \moonland\phpexcel\Excel::export([
                    'models' => $array,
                    'columns' => $array_keys, 
                    'headers' => $array_values,
                    'fileName' => "parent.xlsx"
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ZfParentStudent model.
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
     * Creates a new ZfParentStudent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZfParentStudent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZfParentStudent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ZfParentStudent model.
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
     * Finds the ZfParentStudent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZfParentStudent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZfParentStudent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
