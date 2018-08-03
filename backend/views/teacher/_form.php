<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ZfSchool;
use common\models\ZfClass;
use common\models\ZfRole;
use common\models\ZfCourse;
/* @var $this yii\web\View */
/* @var $model common\models\ZfTeacherClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-teacher-class-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'sid')->dropDownList(
            ZfSchool::find()
            ->select(['name','id'])
            ->indexBy('id')
            ->column(),
            ['readonly'=>"readonly"]
            )->label('学校名称') ?>
    <?= $form->field($model, 'c_id')->dropDownList(
            ZfClass::find()
            ->select(['name'])
            ->where(['sid'=>$model->sid])
            ->indexBy('id')
            ->column()
    )->label('班级') ?>

    <?= $form->field($model, 'role_id')->dropDownList(
            ZfRole::find()
            ->select(['name'])
            ->indexBy('id')
            ->column()
    )->label('角色') ?>

    <?= $form->field($model, 'course_id')->dropDownList(
            ZfCourse::find()
            ->select(['name'])
            ->indexBy('id')
            ->column()
    )->label('所带科目') ?>

    <?= $form->field($model, 'level')->textInput()->label('职级') ?>

    <?= $form->field($model, 'ispass')->dropDownList([ 1 => '通过', 0 => '拒绝', ], ['prompt' => '请选择'])->label('审核') ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
