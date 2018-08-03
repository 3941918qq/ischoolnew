<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ZfSchool;
use common\models\ZfClass;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ZfStudents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zf-students-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('姓名') ?>

    <?= $form->field($model, 'stu_no')->textInput(['maxlength' => true])->label('学号') ?>
    <?php  if ($model->isNewRecord){ ?>
            <?= $form->field($model, 'school_id')->dropDownList(
                ZfSchool::find()
                ->select(['name','id'])
                ->indexBy('id')
                ->column()
                ,[ 'prompt'=>'请选择','id'=>'school-id'])->label('学校名称') ?>
            <?= $form->field($model, 'class_id')->widget(DepDrop::classname(), [
                'options' => ['id'=>'class-id','prompt'=>'请选择'],
                'pluginOptions'=>[
                        'depends'=>['school-id'],
                        'url' => Url::to(['/base/class'])
                ]
            ])->label("班级");?>
    <?php }else{ ?>
           <?= $form->field($model, 'school_id')->dropDownList(
            ZfSchool::find()
            ->select(['name','id'])
            ->indexBy('id')
            ->column(),
            ['readonly'=>"readonly"]
            )->label('学校名称') ?>
            <?= $form->field($model, 'class_id')->dropDownList(
                  ZfClass::find()
                  ->select(['name'])
                  ->where(['sid'=>$model->school_id])
                  ->indexBy('id')
                  ->column()
            )->label('班级') ?>
    <?php }?>
  

    <?= $form->field($model, 'sex')->radioList(["女"=>"女","男"=>"男"])->label('性别') ?>
    
    <?= $form->field($model, 'epc_no')->textInput(['maxlength' => true])->label('EPC') ?>

    <?= $form->field($model, 'tel_no')->textInput(['maxlength' => true])->label('电话卡') ?>

    <?= $form->field($model, 'enddatejx')->widget(DateTimePicker::className(), [
                           'name' => 'to_date',
                            'options' => ['placeholder' => ''],  //注意，该方法更新的时候你需要指定value值
                            'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'todayHighlight' => true
                            ]
                    ])->label('家校沟通有效期') ?>

    <?= $form->field($model, 'enddateqq')->widget(DateTimePicker::className(), [
                           'name' => 'to_date',
                            'options' => ['placeholder' => ''],  //注意，该方法更新的时候你需要指定value值
                            'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'todayHighlight' => true
                            ]
                    ])->label('亲情电话有效期') ?>

    <?= $form->field($model, 'enddateck')->widget(DateTimePicker::className(), [
                           'name' => 'to_date',
                            'options' => ['placeholder' => ''],  //注意，该方法更新的时候你需要指定value值
                            'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'todayHighlight' => true
                            ]
                    ])->label('餐卡有效期') ?>

    <?= $form->field($model, 'enddatepa')->widget(DateTimePicker::className(), [
                           'name' => 'to_date',
                            'options' => ['placeholder' => ''],  //注意，该方法更新的时候你需要指定value值
                            'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'todayHighlight' => true
                            ]
                    ])->label('平安通知有效期') ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
