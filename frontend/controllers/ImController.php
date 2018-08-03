<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use frontend\models\ImPost;
/**
 * Site controller
 */
class ImController extends Controller {

	public $enableCsrfValidation = false;
	/**
	 * @inheritdoc
	 */
	//发送消息数据保存
	public function actionSavesendmessage(){
            $post=Yii::$app->request->post();
            $result=ImPost::saveMes($post);
            return json_encode($result);
	}
	//接收消息数据保存
	public function actionSaverecmessage(){
            $post=Yii::$app->request->post();
            $result=ImPost::saveMesRec($post);
            return json_encode($result);
	}
	//获取历史消息
	public function actionGethismes(){
            $post=Yii::$app->request->post();
            $result=ImPost::getHisMes($post);
            return json_encode($result);
	}
	//获取会话列表
	public function actionGetcoverlist(){
            $post=Yii::$app->request->post();
            $result=ImPost::getCoveList($post);
            return json_encode($result);
	}

}


