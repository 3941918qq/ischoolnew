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
                <li class="active" id="tabdenglu">
                    <a style="font-size: 16px;" href="/index/login" >登录账号</a>
                </li>
                <li id="tabzhuce">
                    <a style="font-size: 16px;" href="/index/register" >注册账号</a>
                </li>
            </ul>
            <div class="tab-content" style="font-size: 14px;padding:30px 50px;">
                <?php $form = ActiveForm::begin(['id' => 'user-login', 'options' => ['class' => 'tab-pane active']]); ?>
                    <?= $form->field($model, 'username',['inputOptions'=>['placeholder'=>'请输入手机号码']])->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>        
                    <div style="color:#999;margin:1em 0">
                         <a data-toggle="modal" data-target="#wjmodal" href="###">忘记密码？</a>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('登录', ['class' => 'btn btn-primary form-control', 'name' => 'login-button']) ?>
                    </div>
               <?php ActiveForm::end(); ?>
                <div class="modal fade" id="wjmodal">
                    <div class="modal-dialog">
                        <form class="modal-content form-horizontal" id="form2" action="/index/findpass" method="post" onsubmit="return checktel()">
                            <div class="modal-header">
                                请输入您的手机号码
                                <button class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                    
                                    <button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-center">
                                    <label for="lastname" class="col-sm-4 control-label">手机号：</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="userPhonwj" id="userPhonwj" class="form-control" placeholder="请输入正确的手机号...">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" >确定</button>
                                <button class="btn btn-danger" data-dismiss="modal">取消<button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    function checktel(){
        var tel = $("#userPhonwj").val();
        var myreg = /^1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}$/;
        if(!myreg.test(tel)){
            alert('请输入有效的手机号码！');
            return false;
        }
        return true;
    }
  
</script>
