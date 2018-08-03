<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfClass */

$this->title = '更新班级';
$this->params['breadcrumbs'][] = ['label' => '班级管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '班级更新';
?>
<div class="zf-class-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
