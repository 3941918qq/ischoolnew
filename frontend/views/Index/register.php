<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="lg_cont">
    <div class="lg_fd">
        <div class="lg_left">
            <img src="" />
        </div>
        <div class="lg_right">
            <ul class="nav nav-tabs nav-justified" id="table1">
                <li  id="tabdenglu">
                    <a style="font-size: 16px;" href="/index/login" >登录账号</a>
                </li>
                <li class="active" id="tabzhuce">
                    <a style="font-size: 16px;" href="/index/register" >注册账号</a>
                </li>
            </ul>
            <div class="tab-content" style="font-size: 14px;padding:30px 50px;">           
                <?php $form = ActiveForm::begin(['id' => 'user-register', 'options' => ['class' => 'tab-pane active']]); ?>
                    <div class="row">
                        <div class="col-xs-6">请选择身份</div>
                        <div class="col-xs-3">
                            <input id="Teacher" type="radio" name="UserRegister[role]" value="teacher" checked="checked"/>
                            <label for="Teacher">老师</label>
                        </div>
                        <div class="col-xs-3">
                            <input id="Parent" type="radio" name="UserRegister[role]"  value="parent" />
                            <label for="Parent">家长</label>
                        </div>
                        
                    </div>                   
                    <div class="zc_cnt">  
                        <?= $form->field($model, 'tel',['inputOptions'=>['placeholder'=>'请输入手机号码']])->textInput(['autofocus' => true]) ?>
                        <?= $form->field($model, 'password',['inputOptions'=>['placeholder'=>'密码长度不得小于6位']])->passwordInput() ?>
                        <?= $form->field($model, 'repassword',['inputOptions'=>['placeholder'=>'重复输入密码']])->passwordInput() ?>
                        <div class="form-group">
                            <?= Html::submitButton('注册', ['class' => 'btn btn-primary form-control', 'name' => 'signup-button']) ?>
                        </div>
                    </div>
               <?php ActiveForm::end(); ?>
                
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
