<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ZfSchool */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zf Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-school-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
//            'pro_id',
            ['label'=>'省份',
             'value'=>$model->pro->name,
            ],
            ['label'=>'城市',
             'value'=>$model->city->name,
            ],
            ['label'=>'城市',
             'value'=>$model->county->name,
            ],
            ['label'=>'学校类型',
             'value'=>$model->schType->name,
            ],
            
        ],
       'template'=>"<tr><th style='width:120px;'>{label}</th><th class='text-center'>{value}</th></tr>"
    ]) ?>

</div>
