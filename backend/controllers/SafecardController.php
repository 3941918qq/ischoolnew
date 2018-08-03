<?php

namespace backend\controllers;

use Yii;
use common\models\ZfSafeCard;
use common\models\ZfSafeCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SafecardController implements the CRUD actions for ZfSafeCard model.
 */
class SafecardController extends BaseController
{
       /**
     * Lists all ZfSafeCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZfSafeCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       if(\yii::$app->request->get("type") && \yii::$app->request->get("type") == "export"){
            foreach($dataProvider->getModels() as $t){
                 $arr[] = $t->attributes;
            }
            $array=$searchModel->getInfo($arr);
            $array_values =[
                'id'=>'ID',
                'stuid' => '学生ID',
                'stuname' => '学生姓名',
                'info' => '类型',
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
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ZfSafeCard model.
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
     * Creates a new ZfSafeCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZfSafeCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZfSafeCard model.
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
     * Deletes an existing ZfSafeCard model.
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
     * Finds the ZfSafeCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZfSafeCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZfSafeCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
