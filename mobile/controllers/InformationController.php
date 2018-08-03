<?php
namespace mobile\controllers;

use Yii;
use yii\web\Controller;

class InformationController extends Controller
{
    public $layout='information';
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionMyallinfo(){
        return $this->render('myallinfo');
    }
}