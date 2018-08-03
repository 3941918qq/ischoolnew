<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;padding: 10px 20px;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left">密码修改</h4>
        </div>
        <?php $form = ActiveForm::begin([
            'id'=>'Change-Pwd',
            'options' => ['class' => 'form-horizontal Modify_pwd'],
            'fieldConfig' => [
                    'template' => ' <label class="col-sm-2 control-label" for="pwd">{label}:</label>
                                      <div class="col-sm-6">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                   'inputOptions' => ['class' => 'form-control'],
                 ],
            ]); ?>

            <?= $form->field($model, 'pwd',['labelOptions' => ['class' => 't-r-pd5']])->passwordInput()->label('当前密码'); ?>
            <?= $form->field($model, 'newPwd',['labelOptions' => ['class' => 't-r-pd5']])->passwordInput()->label('新密码'); ?>
            <?= $form->field($model, 'reNewPwd',['labelOptions' => ['class' => 't-r-pd5']])->passwordInput()->label('确认密码'); ?>
           <div class="form-group">
               <div class="col-sm-2 col-sm-offset-2">
                 <?= Html::submitButton('提交', ['class' => 'form-control btn-success']) ?>
               </div>
            </div>
               
        <?php ActiveForm::end(); ?>
    </div>
</div>