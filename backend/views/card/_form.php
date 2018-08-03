<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfCardLibrary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-card-library-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cardno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'epcno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
