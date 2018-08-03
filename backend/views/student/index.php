<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfStudentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学生管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-students-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加学生', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <?= Html::a('导出', [strpos(\yii::$app->request->url,"?")>-1? \yii::$app->request->url.'&type=export':\yii::$app->request->url.'?type=export'], ['class' => 'btn btn-primary pull-right','target'=>"_blank"]) ?>
        <?=       Html::a('批量更新', ['batchedit?'.\yii::$app->request->queryString], ['class' => 'btn btn-danger pull-right','target'=>"_blank"]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
              'attribute'=>'name',
              'label'=>'姓名'
            ],
            [
              'attribute'=>'stu_no',
              'label'=>'学号'
            ],
            [
              'attribute'=>'class',
              'value'=>'class.name',
              'label'=>'班级',
            ],
            [
                'attribute'=>'school',
                'value'=>'school.name',
                'label'=>'学校',
            ],
            [
              'attribute'=>'epc_no',
              'label'=>'EPC'
            ],
            [
              'attribute'=>'tel_no',
              'label'=>'电话卡'
            ],
            [
              'attribute'=>'enddatejx',
              'label'=>'家校沟通有效期'
            ],
            [
              'attribute'=>'enddateqq',
              'label'=>'亲情电话有效期'
            ],
            [
              'attribute'=>'enddateck',
              'label'=>'餐卡有效期'
            ],
            [
              'attribute'=>'enddatepa',
              'label'=>'平安通知有效期'
            ],

            [
             'class' => 'yii\grid\ActionColumn',
              'template'=>'{update} {delete} {bind}',
              'buttons'=>[
                   'bind'=>function($url,$model,$key){
                        return \yii\bootstrap\Html::a("<span class='glyphicon glyphicon-plus-sign'></span>",$url);
                   }
              ]
            ],
        ],
    ]);
    ?>
</div>
