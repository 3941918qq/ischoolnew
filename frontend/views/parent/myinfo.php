<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use common\models\ZfProvince;
use common\models\ZfCourse;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;padding: 20px;box-shadow: 0 0 2px #ccc;">
        <div class="media">
            <a href="###" class="pull-left">
                <img src="/img/pc_ren.png" />
            </a>
            <table class="media-body" style="line-height: 30px;">
                <tr>
                    <td style="width: 250px;">你好，用户<span class="xiugai" id="xiugaiyh2"><?= Html::encode($userInfo['name']) ?></span>家长！</td>
                    <td></td>
                </tr>
                <tr>
                    <td>用户名：<p style="display: none"><?=$userInfo['id']?></p><strong style="font-weight: 400"><?= Html::encode($userInfo['name']) ?></strong><a href="###"><span class="xiugai" id="xiugaiyh">点击修改</span></a></td>
                    <td>手机号：<p style="display: none"><?=$userInfo['id']?></p><strong style="font-weight: 400"><?= Html::encode($userInfo['tel']) ?></strong><a href="###"><span class="xiugai" id="xiugaisj">点击修改</span></a></td>
                </tr>
                <tr>
                    <td>上次登录时间：<?= Html::encode($userInfo['last_login_time']) ?></td>
                </tr>
                <tr>
                    <td>我的学生：<span class="xiugai"><?=count($stuinfo);?></span>个</td>
                </tr>
            </table>
        </div>
    </div>
    <div style="background-color: #ffffed;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
        <img src="../img/pc_dng.png" />
        <span style="vertical-align: middle;padding-left: 5px;"><?php if(!empty($stuinfo)){echo "您已关注学生，可关注多位学生信息。";}else{echo "你还没有关注学生，可以先关注学生";} ?></span>
    </div>
    <div style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left">已关注学生</h4>
            <button class="btn btn-info pull-right" data-toggle="modal" data-target="#gzModal" id="gzbtn" >关注学生</button>
        </div>
        <table class="table table-bordered text-center" style="margin-top: 20px;">
            <tr style="background-color: #eee;">
                <td>序号</td>
                <td>姓名</td>
                <td>学校</td>
                <td>班级</td>
                <td>操作</td>
            </tr>
            <?php if(!empty($stuinfo)){ foreach($stuinfo as $key=>$value){ ?>
            <tr>
                <td><?php echo $key; ?></td>
                <td><?php echo $value['stu']['name']; ?></td>
                <td><?php echo $value['s']['name']; ?></td>
                <td><?php echo $value['class']; ?></td>
                <td>
                   <a style="color: #e75d50;" href="<?= Url::to(['/parent/delstu', 'id' => $value['id']]) ?>" onClick="return confirm('确认取消绑定?');";>取消绑定</a>
                </td>
            </tr>
            <?php } } ?>
        </table>
    </div>
</div>

<!--关注学生-->
<div class="modal fade" id="gzModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <h4 class="modal-header">
                绑定班级
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </h4>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id'=>'Bind-Student',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                            'template' => ' <label class="col-sm-3 control-label" >{label}:</label><div class="col-sm-6">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                            'inputOptions' => ['class' => 'form-control '],
                         ],
                    ]); ?>
                
                    <?= $form->field($model, 'pro_id',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList(
                         ZfProvince::find()
                         ->select(['name','id'])
                         ->indexBy('id')
                         ->column(),
                         ['prompt'=>'请选择省份','id'=>"pro-id"])->label('省'); ?>

                    <?= $form->field($model, 'city_id',['labelOptions' => ['class' => 't-r-pd5']])->widget(DepDrop::classname(), [
                          'options' => ['id'=>'city-id','prompt'=>'请选择'],
                          'pluginOptions'=>[
                                  'depends'=>['pro-id'],
                                  'url' => Url::to(['/base/citys'])
                          ]
                      ])->label('市');?>
                    <?= $form->field($model, 'county_id',['labelOptions' => ['class' => 't-r-pd5']])->widget(DepDrop::classname(), [
                          'options' => ['id'=>'county-id','prompt'=>'请选择'],
                          'pluginOptions'=>[
                                  'depends'=>['city-id'],
                                  'url' => Url::to(['/base/countys'])
                          ]
                      ])->label("县区");?>
                    <?= $form->field($model, 'school_id',['labelOptions' => ['class' => 't-r-pd5']])->widget(DepDrop::classname(), [
                          'options' => ['id'=>'school-id','prompt'=>'请选择'],
                          'pluginOptions'=>[
                                  'depends'=>['county-id'],
                                  'url' => Url::to(['/base/schools'])
                          ]
                      ])->label("学校");?>
                    <?= $form->field($model, 'class_id',['labelOptions' => ['class' => 't-r-pd5']])->widget(DepDrop::classname(), [
                          'options' => ['id'=>'class-id','prompt'=>'请选择'],
                          'pluginOptions'=>[
                                  'depends'=>['school-id'],
                                  'url' => Url::to(['/base/class'])
                          ]
                      ])->label("班级");?>
                    <?= $form->field($model, 'stuname',['labelOptions' => ['class' => 't-r-pd5']])->textInput()->label('姓名'); ?>
                    <input type="hidden" name="BindStudent[parent_id]" value="<?= $parent_id?>">
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                          <?= Html::submitButton('提交', ['class' => 'form-control btn-success']) ?>
                        </div>
                     </div>
                      
                
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $("#identity").change(function(){
            var ID=$("#identity").val();
            if(ID==1){
                $("#tea_role").hide();
            }else{
                $("#tea_role").show();
            }
        })
    })
    //        修改用户名
    $("#xiugaiyh").click(function(){
          var obj=$(this);
          upUserInfo(obj,'name');
    })
    //修改手机号
    $("#xiugaisj").click(function(){
        var obj=$(this);
        upUserInfo(obj,'tel');
        
    })
    function upUserInfo(obj,type){
        var strong = obj.parent().siblings('strong');
        var text = strong.text();
        var input = $("<input  size='10' type='text' value='" + text + "'/>");
        strong.html(input);
        obj.hide();
        input.click(function () {
            return false;
        });
        //获取焦点
        input.trigger("focus");
        input.blur(function(){
            var newtext = $(this).val();
            
            //判断文本有没有修改
            if (newtext != text){
                if(type=='tel'){
                    var myreg = /^1[3|4|5|7|8][0-9]{9}$/;
                    if(!myreg.test(newtext))
                    {
                        alert('请输入有效的手机号码！');
                        return false;
                        die;
                    }
                    var formData = {};
                    formData.id = $.trim($(this).parents("td").children('p').text());
                    formData.tel =newtext;
                }else{
                     var formData = {};
                     formData.id = $.trim($(this).parents("td").children('p').text());
                     formData.name =newtext;
                }
                
                
                var url ="/teacher/upinfo";
                $.post(url,formData).done(function(data) {
                    alert(data.message);
                })
                if(type=='name'){
                    $("#xiugaiyh2").html(newtext);
                }
                strong.html(newtext);
                obj.show();
            }else {
                strong.html(text);
                obj.show();
            }
        })
    }
</script>





