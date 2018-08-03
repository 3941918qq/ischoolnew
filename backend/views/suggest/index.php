<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfSuggestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '意见反馈';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-suggest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
//            'content:ntext',
            'sid',
            'submitTime',
            //'attachment',
            //'uid',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update}'
                ],
        ],
    ]); ?>
</div>
