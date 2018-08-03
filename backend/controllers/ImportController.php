<?php 
namespace backend\controllers;

use Yii;
use common\models\ZfClass;
use common\models\ZfClassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use common\models\ImportData;
use yii\web\UploadedFile;
use backend\models\Import;

class ImportController extends BaseController{

	private $source_data;
	public function actionIndex(){		
            return $this->render("index");
	}
	private function assignPage($errorinfo){
            return $this->render("page",[
                            "errorinfo"=>$errorinfo
            ]);
	}
	public function init()
	{
            if (Yii::$app->request->isPost) {
                $model = new ImportData();
                $model->upload = UploadedFile::getInstance($model, 'upload');
                if ($model->validate()) {
                    $data = \moonland\phpexcel\Excel::widget([
                                    'mode' => 'import',
                                    'fileName' => $model->upload->tempName,
                                    'setFirstRecordAsKeys' => false,
                                    'setIndexSheetByName' => false,

                    ]);
                    $data = isset($data[0])?$data[0]:$data;
                    if(count($data) > 1)
                    {
                            array_shift($data);
                            $this->source_data = $data;
                    }
                    else return $this->assignPage("文件格式错误");
                }
            }
	}

	public function actionStudent(){
            if(!$this->source_data) $this->redirect("/import/index");
            $result=Import::ImportStudent($this->source_data);
            return $this->assignPage($result);
	}

	public  function actionPhones(){
	    if(!$this->source_data) $this->redirect("/import/index");
	    $result=Import::ImportPhones($this->source_data);
	    return $this->assignPage($result);
	}
	public  function actionEpc(){
	    if(!$this->source_data) $this->redirect("/import/index");
	    $result=Import::ImportEpc($this->source_data);
	    return $this->assignPage($result);
	}
	public  function actionKaku(){
	    if(!$this->source_data) $this->redirect("/import/index");
	    $result=Import::ImportKaku($this->source_data);
	    return $this->assignPage($result);
	}
        //EPC电话卡导入
        public  function actionEpcTel(){
	    if(!$this->source_data) $this->redirect("/import/index");
	    $result=Import::ImportEpcTel($this->source_data);
	    return $this->assignPage($result);
	}
        //用户信息导入
        public  function actionUser(){
	    if(!$this->source_data) $this->redirect("/import/index");
	    $result=Import::ImportUser($this->source_data);
	    return $this->assignPage($result);
	}
}
