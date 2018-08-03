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
                    <td style="width: 250px;">你好，用户<span class="xiugai" id="xiugaiyh2"><?=$userInfo['name']?></span>校长！</td>
                    <td></td>
                </tr>
                <tr>
                    <td>用户名：<p style="display: none"><?=$userInfo['id']?></p><strong style="font-weight: 400"><?=$userInfo['name']?></strong><a href="###"><span class="xiugai" id="xiugaiyh">点击修改</span></a></td>
                    <td>手机号：<p style="display: none"><?=$userInfo['id']?></p><strong style="font-weight: 400"><?=$userInfo['tel']?></strong><a href="###"><span class="xiugai" id="xiugaisj">点击修改</span></a></td>
                </tr>
                <tr>
                    <td>上次登录时间：<?=$userInfo['last_login_time']?></td>
                </tr>
                <tr>
                    <td>我的学校：<span class="xiugai"><?=count($manageInfo);?></span>个</td>
                </tr>
            </table>
        </div>
    </div>
    <div style="background-color: #ffffed;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
        <img src="/img/pc_dng.png" />
        <span style="vertical-align: middle;padding-left: 5px;"><?php if(!empty($manageInfo)){ echo "您已绑定学校";}else{echo "您还没有绑定学校，请先绑定学校";}?></span>
    </div>
    <div style="background-color: white;padding: 10px 20px;margin-top: 5px;height: auto;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left">已绑定学校</h4>        
        </div>
        <table class="table table-bordered text-center" style="margin-top: 20px;">
            <tr style="background-color: #eee;">
                <td>序号</td>
                <td>学校</td>
                <td>类型</td>
                <td>审核</td>
                <td>操作</td>
            </tr>

            <?php foreach ($manageInfo as $key=>$value){?>
            <tr>
                <td><?=$key+1?></td>
                <td><?=$value['s']['name']?></td>
                <td><?=$value['s']['school_type']?></td> 
                <td><?=($value['ispass']=="1")?"已审核":"未审核"; ?></td>
                <td>
                   <a style="color: #e75d50;" href="<?= Url::to(['/manage/delschool', 'id' => $value['id']]) ?>" onClick="return confirm('确认取消绑定?');";>取消绑定</a>
                </td>
            </tr>
            <?php }?>
        </table>
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



