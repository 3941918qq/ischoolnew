<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfTeacherClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '教师管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-teacher-class-index">

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
            
            [
               'attribute'=>'name',
               'label'=>'姓名',
               'value'=>'t.name'
            ],
            [
               'attribute'=>'school',
               'label'=>'学校',
               'value'=>'s.name'
            ],
            [
               'attribute'=>'class',
               'label'=>'班级',
               'value'=>'c.name'
            ],
            [
               'attribute'=>'c_id',
               'label'=>'班级ID',
            ],
            [
               'attribute'=>'role',
               'label'=>'角色',
               'value'=>'role.name'
            ],
            [
               'attribute'=>'course',
               'label'=>'学科',
               'value'=>'course.name'
            ],
            [
               'attribute'=>'ispass',
               'label'=>'是否审核',
               'filter'=>['0'=>'未审核','1'=>'已审核'],
               'value'=>function($model){
                    return ($model->ispass==1) ?'已审核':'未审核';
                },
                'contentOptions'=>['text-align'=>'left']
            ],
            [
               'attribute'=>'tel',
               'label'=>'电话',
               'value'=>'t.tel'
            ],
            //'level',
            // 'sid',
            // 'ispass',
            //'created',

            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}',
            'header'=>'操作'
            ],
        ],
    ]); ?>
</div>
