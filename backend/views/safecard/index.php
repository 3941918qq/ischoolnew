<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfSafeCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '刷卡记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-safe-card-index">

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
            'stuid',
            [
                'attribute'=>'stuname',
                'label'=>'学生姓名',
                'value'=>'stu.name'
            ],
            'info',
//            'ctime:datetime',
//            'yearmonth',
            //'yearweek',
            //'weekday',
            [
                'attribute'=>'creat_stamptime',
                'label'=>'创建时间',
                'value'=>'ctime',
                'format'=>['date','php:Y-m-d H:i:s']
            ],

            [
                'attribute'=>'receive_stamptime',
                'label'=>'接收时间',
                'value'=>'receivetime',
                'format'=>['date','php:Y-m-d H:i:s']
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
