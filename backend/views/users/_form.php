<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('姓名') ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true])->label('电话') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('密码') ?>

    <?= $form->field($model, 'role_type')->dropDownList([ 'parent' => 'Parent', 'teacher' => 'Teacher', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_pass')->textInput()->label('是否通过') ?>

    <?= $form->field($model, 'openid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pushid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_sid')->textInput()->label('当前学校id') ?>

    <?= $form->field($model, 'last_stuid')->textInput()->label('当前学生id') ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
