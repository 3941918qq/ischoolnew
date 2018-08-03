<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfSuggestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-suggest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'sid') ?>

    <?= $form->field($model, 'submitTime') ?>
    
    <?= $form->field($model, 'note') ?> 

    <?php // echo $form->field($model, 'attachment') ?>

    <?php // echo $form->field($model, 'uid') ?>
    
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
