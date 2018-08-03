<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--     <p>
        <?= Html::a('导出', [strpos(\yii::$app->request->url,"?")>-1? \yii::$app->request->url.'&type=export':\yii::$app->request->url.'?type=export'], ['class' => 'btn btn-danger pull-right','target'=>"_blank"]) ?>
    </p> -->

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
                'attribute'=>'tel',
                'label'=>'电话'
            ],
            [
                'attribute'=>'password',
                'label'=>'密码'
            ],
            [
                'attribute'=>'role_type',
                'label'=>'角色',
                'filter'=>['parent'=>'家长','teacher'=>'老师'],
                'value'=>function($model){
                    return ($model->role_type=='parent') ?'家长':'老师';
                }

            ],
            //'is_pass',
            'openid',
            'pushid',
            //'uuid',
            //'last_sid',
            //'last_stuid',
            [
                'attribute'=>'last_login_time',
                'label'=>'最后登录时间'
            ],
            //'register_time',
            //'updated',

            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>"{update} {delete}",
            'header'=>'操作'
            ],
        ],
    ]); ?>
</div>
