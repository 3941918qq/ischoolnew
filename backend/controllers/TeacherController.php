<?php

namespace backend\controllers;

use Yii;
use common\models\ZfTeacherClass;
use common\models\ZfTeacherClassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * TeacherController implements the CRUD actions for ZfTeacherClass model.
 */
class TeacherController extends BaseController
{
    /**
     * Lists all ZfTeacherClass models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZfTeacherClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export"){
            foreach($dataProvider->getModels() as $t){
                 $arr[] = $t->attributes;
            }
            $array=$searchModel->getInfo($arr);
            $array_values =[
                'name' => '名称',
                'school' => '学校',
                'class' => '班级',
                'c_id' => '班级ID',
                'role' => '角色',
                'course' => '所带科目',
                'ispass' => '是否通过0未通过，1已通过',
                'tel'=>'电话'
            ];
            $array_keys = array_keys($array_values);
            \moonland\phpexcel\Excel::export([
                    'models' => $array,
                    'columns' => $array_keys, 
                    'headers' => $array_values,
                    'fileName' => "teacher.xlsx"
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ZfTeacherClass model.
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
     * Creates a new ZfTeacherClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZfTeacherClass();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZfTeacherClass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ZfTeacherClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZfTeacherClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZfTeacherClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
