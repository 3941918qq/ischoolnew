<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <div class="clearfix">
            <h4 class="pull-left">平安通知</h4>        
        </div>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'stuname',
                'label'=>'学生姓名',
                'value'=>'stu.name'
            ],
            [
                'attribute'=>'classname',
                'label'=>'班级',
                'value'=>function($model){
                    return $model->stuidGetClass($model->stuid);
                }
            ],
            [
                'attribute'=>'info',
                'label'=>'进/出校',
            ],
            [
                'attribute'=>'creat_stamptime',
                'label'=>'发送时间',
                'value'=>'ctime',
                'format'=>['date','php:Y-m-d H:i:s']
            ],

            [
                'attribute'=>'receive_stamptime',
                'label'=>'接收时间',
                'value'=>'receivetime',
                'format'=>['date','php:Y-m-d H:i:s']
            ],
        ],
    ]); ?>
    </div>
</div>

