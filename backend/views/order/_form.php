<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'inside_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trade_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paytype')->dropDownList([ 'JSAPI' => 'JSAPI', 'WXAPPJSAPI' => 'WXAPPJSAPI', 'ZFBJSAPI' => 'ZFBJSAPI', 'SDTJ' => 'SDTJ', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ispasspa')->dropDownList([ 1 => '1', 0 => '0', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ispassjx')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ispassqq')->dropDownList([ 1 => '1', 0 => '0', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ispassck')->dropDownList([ 1 => '1', 0 => '0', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ispass')->dropDownList([ 1 => '1', 0 => '0', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'submitTime')->textInput() ?>

    <?= $form->field($model, 'updateTime')->textInput() ?>

    <?= $form->field($model, 'stu_id')->textInput() ?>

    <?= $form->field($model, 'trans_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Bookfee' => 'Bookfee', 'Hotelexpense' => 'Hotelexpense', 'Functional' => 'Functional', 'buka' => 'Buka', 'Tuition' => 'Tuition', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
