<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfParentStudent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-parent-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'stu_id')->textInput()->label("学生ID") ?>

    <?= $form->field($model, 'sid')->textInput()->label("学校ID") ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
