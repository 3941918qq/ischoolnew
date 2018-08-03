<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ZfSchool;
/* @var $this yii\web\View */
/* @var $model common\models\ZfClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-class-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('班级名称') ?>

    <?= $form->field($model, 'level')->dropDownList($model->getLevel(),['prompt'=>'请选择年级'])->label('年级') ?>

    <?= $form->field($model, 'class')->dropDownList($model->getClassnumber(),['prompt'=>'请选择年级'])->label('班级') ?>
    
    <?= $form->field($model, 'sid')->dropDownList(
            ZfSchool::find()
            ->select(['name','id'])
            ->indexBy('id')
            ->column(),
            ['readonly'=>"readonly"]
            )->label('学校名称') ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
