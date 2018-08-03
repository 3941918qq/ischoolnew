<?php 
namespace mobile\controllers;

use Yii;
use yii\web\controller;
class HomepageController extends controller{
    public $layout='header';
    public function actionIndex(){
    	return $this->render('index');
    }
}
