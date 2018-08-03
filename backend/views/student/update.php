<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfStudents */

$this->title = '更新学生信息';
$this->params['breadcrumbs'][] = ['label' => '学生信息', 'url' => ['index']];

$this->params['breadcrumbs'][] = '更新学生';
?>
<div class="zf-students-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
