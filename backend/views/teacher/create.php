<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfTeacherClass */

$this->title = '添加老师';
$this->params['breadcrumbs'][] = ['label' => '教师管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加老师';
?>
<div class="zf-teacher-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
