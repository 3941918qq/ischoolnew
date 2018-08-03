<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfParentStudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '家长管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-parent-student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('导出', [strpos(\yii::$app->request->url,"?")>-1? \yii::$app->request->url.'&type=export':\yii::$app->request->url.'?type=export'], ['class' => 'btn btn-danger pull-right','target'=>"_blank"]) ?>
    </p> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
               'attribute'=>'parent_name',
               'label'=>'家长姓名',
               'value'=>'parent.name'
            ],
            [
               'attribute'=>'parent_tel',
               'label'=>'电话',
               'value'=>'parent.tel'
            ],
            [
               'attribute'=>'stu_name',
               'label'=>'学生姓名',
               'value'=>'stu.name'
            ],
            [
               'attribute'=>'stu_id',
               'label'=>'学生ID',
            ],
            [
               'attribute'=>'class',
               'label'=>'班级',
               'value'=>function($model){
                  $res=$model->getClass($model->stu_id);
                  return $res['name'];
               }               
            ],
            [
               'attribute'=>'cid',
               'label'=>'班级ID',
               'value'=>function($model){
                  $res=$model->getClass($model->stu_id);
                  return $res['id'];
               }               
            ],

            [
               'attribute'=>'school',
               'label'=>'学校',
               'value'=>'s.name'
            ],


            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}',
            'header'=>'操作'
            ],
        ],
    ]); ?>
</div>
