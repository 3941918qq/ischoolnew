<?php
use yii;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <div class="clearfix">
            <h4 class="pull-left">请假信息</h4>
         
        </div>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//      'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute'=>'name',
               'label'=>'姓名',
               'value'=>'stu.name'
            ],
            [
               'attribute'=>'class',
               'label'=>'班级',
               'value'=>function($model){
                   return $model->getClass($model->stu_id);
               }
            ],
            [
               'attribute'=>'startTime',
               'label'=>'开始时间',
            ],  
            [
               'attribute'=>'endTime',
               'label'=>'结束时间',
            ],
            [
               'attribute'=>'reason',
               'label'=>'请假理由',
                'value'=>function($model){
                       $tmpStr= strip_tags($model->reason);
                       $tmpLen=mb_strlen($tmpStr);
                       return mb_substr($tmpStr, 0,20,'utf-8').(($tmpLen>20) ? '...':'');
                }
            ],        
            [
               'attribute'=>'flag',
               'label'=>'是否批假',
               'filter'=>['0'=>'已失效','1'=>'已批准','2'=>'待批准','3'=>'已拒绝'],
               'value'=>function($model){
                    switch($model->flag){
                        case 0:
                            return '已失效';
                            break;
                        case 1:
                            return '已批准';
                            break;
                        case 2:
                            return '待批准';
                            break;
                       default;  
                            return'已拒绝' ;
                    }
                    return ($model->flag==1) ?'已审核':'待审核';
                },
                'contentOptions'=>function($model){
                    return ($model->flag==2) ? ['class'=>'bg-danger'] :'';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{approve} {refuse} ',
                'header'=>'操作',
                'buttons'=>[
                    'approve'=>function($url,$model,$key){
                            $options=[
                                'title'=>'yii','审核',
                                'aria-label'=>'yii','审核',
                                'data-confirm'=>'你确定批准该请假么？',                               
                            ];
                           return \yii\bootstrap\Html::a("<span  class='glyphicon glyphicon-check'></span>",Url::to("/teacher/approve?id=".$model->id),$options);
                    },
                         
                    'refuse'=>function($url,$model,$key){
                        $options=[
                                'title'=>'yii','审核',
                                'aria-label'=>'yii','审核',
                                'data-confirm'=>'你确定拒绝该请假么？',                               
                            ];
                           return \yii\bootstrap\Html::a("<span  class='glyphicon glyphicon-remove'></span>",Url::to("/teacher/refuse?id=".$model->id),$options);
                    }
                ]
            ],
        ],       
    ]); ?>
    </div>
</div>

