<?php 
namespace mobile\controllers;

use Yii;
use yii\web\controller;
class ZfendController extends controller{
    public function actionIndex(){
        
    	return $this->renderPartial('index');
    }
}

