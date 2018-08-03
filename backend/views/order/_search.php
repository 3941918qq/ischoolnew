<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'total') ?>

    <?= $form->field($model, 'inside_no') ?>

    <?= $form->field($model, 'trade_name') ?>

    <?= $form->field($model, 'paytype') ?>

    <?php // echo $form->field($model, 'ispasspa') ?>

    <?php // echo $form->field($model, 'ispassjx') ?>

    <?php // echo $form->field($model, 'ispassqq') ?>

    <?php // echo $form->field($model, 'ispassck') ?>

    <?php // echo $form->field($model, 'ispass') ?>

    <?php // echo $form->field($model, 'submitTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <?php // echo $form->field($model, 'stu_id') ?>

    <?php // echo $form->field($model, 'trans_id') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
