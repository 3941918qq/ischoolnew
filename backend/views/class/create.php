<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfClass */

$this->title = '添加班级';
$this->params['breadcrumbs'][] = ['label' => '班级管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加班级';
?>
<div class="zf-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
