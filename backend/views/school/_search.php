<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ZfSchoolSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-school-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'pro_id') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'county_id') ?>

    <?php // echo $form->field($model, 'sch_type') ?>

    <?php // echo $form->field($model, 'setting') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'ispass') ?>

    <?php // echo $form->field($model, 'ckpass') ?>

    <?php // echo $form->field($model, 'skpass') ?>

    <?php // echo $form->field($model, 'papass') ?>

    <?php // echo $form->field($model, 'jxpass') ?>

    <?php // echo $form->field($model, 'qqpass') ?>

    <?php // echo $form->field($model, 'xfpass') ?>

    <?php // echo $form->field($model, 'month_total') ?>

    <?php // echo $form->field($model, 'half_total') ?>

    <?php // echo $form->field($model, 'year_total') ?>

    <?php // echo $form->field($model, 'is_youhui') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
