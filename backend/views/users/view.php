<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ZfUser */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zf Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'tel',
            'password',
            'role_type',
            'is_pass',
            'openid',
            'pushid',
            'uuid',
            'last_sid',
            'last_stuid',
            'last_login_time',
            'register_time',
            'updated',
        ],
    ]) ?>

</div>
