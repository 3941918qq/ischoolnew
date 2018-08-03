<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfStudents */

$this->title = '添加学生';
$this->params['breadcrumbs'][] = ['label' => '学生管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加学生';
?>
<div class="zf-students-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
