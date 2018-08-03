<?php

namespace backend\controllers;

use Yii;
use common\models\ZfSchool;
use common\models\ZfSchoolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * SchoolController implements the CRUD actions for ZfSchool model.
 */
class SchoolController extends BaseController
{
    /**
     * Lists all ZfSchool models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZfSchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export"){
            foreach($dataProvider->getModels() as $t){
                 $arr[] = $t->attributes;
            }
            $array=$searchModel->getInfo($arr);
            $array_values =[
                'name' => '名称',
                'id' => 'ID',
                'pro' => '省份',
                'city' => '城市',
                'county' => '县区',
                'schooltype' => '类型'
            ];
            $array_keys = array_keys($array_values);
            \moonland\phpexcel\Excel::export([
                    'models' => $array,
                    'columns' => $array_keys, 
                    'headers' => $array_values,
                    'fileName' => "school.xlsx"
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ZfSchool model.
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
     * Creates a new ZfSchool model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZfSchool();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZfSchool model.
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
     * Deletes an existing ZfSchool model.
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
     * Finds the ZfSchool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZfSchool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZfSchool::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
