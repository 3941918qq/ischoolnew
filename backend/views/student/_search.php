<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfStudentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-students-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'stu_no') ?>

    <?= $form->field($model, 'sex') ?>

    <?= $form->field($model, 'class_id') ?>

    <?php // echo $form->field($model, 'school_id') ?>

    <?php // echo $form->field($model, 'epc_no') ?>

    <?php // echo $form->field($model, 'tel_no') ?>

    <?php // echo $form->field($model, 'enddatejx') ?>

    <?php // echo $form->field($model, 'upendtimejx') ?>

    <?php // echo $form->field($model, 'enddateqq') ?>

    <?php // echo $form->field($model, 'upendtimeqq') ?>

    <?php // echo $form->field($model, 'enddateck') ?>

    <?php // echo $form->field($model, 'upendtimeck') ?>

    <?php // echo $form->field($model, 'enddatepa') ?>

    <?php // echo $form->field($model, 'upendtimepa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
