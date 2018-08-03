<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-order-index">

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
                'attribute'=>'total',
                'label'=>'总额'
            ],
            [
                'attribute'=>'inside_no',
                'label'=>'订单号'
            ],
            [
                'attribute'=>'trade_name',
                'label'=>'商品名称'
            ],
            [
                'attribute'=>'paytype',
                'label'=>'支付方式',
                'filter'=>['JSAPI'=>'JSAPI','JSAPI'=>'JSAPI','WXAPPJSAPI'=>'WXAPPJSAPI','ZFBJSAPI'=>'ZFBJSAPI','SDTJ'=>'SDTJ']
            ],          
            // 'ispass',
            [
                'attribute'=>'updateTime',
                'label'=>'提交时间'

            ],
            [
                'attribute'=>'uid',
                'label'=>'用户ID'
            ],
            [
                'attribute'=>'stu_id',
                'label'=>'学生ID'
            ],
            //'submitTime',
            //'updateTime',
            //'stu_id',
            //'trans_id',
            [
                'attribute'=>'type',
                'label'=>'缴费类型'
            ],
            //'uid',
            // [
            //     'attribute'=>'ispasspa',
            //     'label'=>'平安通知'
            // ],
            // [
            //     'attribute'=>'ispassjx',
            //     'label'=>'家校沟通'
            // ],
            // [
            //     'attribute'=>'ispassqq',
            //     'label'=>'亲情电话'
            // ],
            // [
            //     'attribute'=>'ispassck',
            //     'label'=>'餐卡'
            // ],

            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>"{delete}",
            'header'=>'操作'
            ],
        ],
    ]); ?>
</div>
