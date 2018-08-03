<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <div class="clearfix">
            <h4 class="pull-left">消费记录</h4>        
        </div>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'学生姓名',
                'attribute'=>'user_name',
                 'value'=>'user.user_name'
            ],
            [
                'label'=>'卡号',
                'attribute'=>'card_no'
            ],          
            [
                'label'=>'消费地点',
                'value'=>function ($model){
                   return $model->getPositon($model->school_id,$model->pos_sn);
                }
                
            ],
            [
                'label'=>'消费金额',
                'attribute'=>'amount'
            ],
            [
                'label'=>'余额',
                'attribute'=>'balance'
            ],
            [
                'attribute'=>'receivetime',
                'label'=>'消费时间',
                'value'=>'created',
                'format'=>['date','php:Y-m-d H:i:s']
            ],
        ],
    ]); ?>
    </div>
</div>



