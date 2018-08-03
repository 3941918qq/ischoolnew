<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ZfSchool;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '班级管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-class-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建班级', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <?= Html::a('导出', [strpos(\yii::$app->request->url,"?")>-1? \yii::$app->request->url.'&type=export':\yii::$app->request->url.'?type=export'], ['class' => 'btn btn-danger pull-right','target'=>"_blank"]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'班级名称',
                'attribute'=>'name'
            ],
            [
                'label'=>'班级ID',
                'attribute'=>'id'
            ],
            [
                'label'=>'班级',
                'attribute'=>'class',
                'value'=>function($model){
                     $arr=$model->getClassnumber();
                     return $arr["$model->class"]."班";
                }
            ],
            [
                'label'=>'年级',
                'attribute'=>'level',
                'value'=>function($model){
                     $arr=$model->getLevel();
                     return $arr["$model->level"];
                }
            ],
            [
                'label'=>'学校',
                'value'=>'s.name',
                'attribute'=>'school_name'
            ],
            // 'sid',
            //'created',

            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}',

            ],
        ],
    ]); ?>
</div>
