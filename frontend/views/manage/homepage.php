<?php
use yii\widgets\ActiveForm;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;padding: 10px 20px;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left">学校首页轮播设置</h4>
        </div>
        <hr/>
        <div class="zt_img" id="tupian">
            <?php foreach($allLunbo  as $key => $value){ ?>
           <label for="img<?=$key?>" > <img src="/<?=$value['picurl']?>" /></label><input type="checkbox" value="<?=$value['id']?>" id="img<?=$key?>">
            <?php } ?>
        </div>
        <div style="margin-top: 10px;">
            <style>
                #w0{
                    display: inline-block;
                }
            </style>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'file')->fileInput()->label(false) ?>
            <?php if(!$sid){echo "上传图片功能需要绑定学校后才能使用！";}else{?>
            <button class="btn zd_btn3">上传图片</button>
            <?php }?>
            <?php ActiveForm::end() ?>
            <?php if(!$sid){echo "";}else{?>
            <button style="display: inline-block; vertical-align: bottom" class="btn" onclick="delpic()">删除图片</button>
            <?php }?>
        </div>
    </div>
    <div>
	<h5 style="margin-left:10px;color:red">上传图片请保持16:9的比例，否则会对图片进行自动裁切。</h5>
    </div>
    <div style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left">学校首页栏目设置</h4>
        </div>
        <form class="form-group dropdown-toggle clearfix">
            <div class="input-group col-xs-9 pull-left">
                <input id="addtitle" style="height: 40px;" class="form-control" type="text" placeholder="请输入新增的栏目标题..." />
            </div>
            <?php if(!$sid){echo "首页栏目设置需要绑定学校后才能使用！";}else{?>
            <button type="button" class="btn pull-left" style="background-color: #36ADFF;margin-left: 30px; color: white;line-height: 26px;" onclick="addcol()">新增</button>
            <?php }?>
        </form>
        <ul>
            <?php   if($sid){  foreach($allColumn as $key => $value){?>
            <li class="row text-center" style="background-color: #e8e8e8;margin-top: 5px;padding: 6px 0;border: 1px solid #ccc" >
                <div class="col-sm-9 text-left">
                    <span><?=$value['columnName']?></span>
                </div>
                <button class="col-xs-1 btn zd_btn4" data-toggle="modal" data-target="#bjModal" value="<?=$value['columnName']?>" id="<?=$value['id']?>" onclick="edit(this)">编辑</button>
                <button class="col-sm-1 btn zd_btn5" id="<?=$value['id']?>" onclick="delColname(this)">删除</button>
            </li>
            <?php } }?>
        </ul>
    </div>
</div>
</div>
</div>
<!--栏目编辑弹窗-->
<div class="modal fade" id="bjModal">
    <div class="modal-dialog" style="width: 400px;">
        <div class="modal-content">
            <h4 class="modal-header">
                栏目编辑
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </h4>
            <div class="modal-body">
                <form>
                    <input id="editcol" style="width: 60%;margin: 20px auto;" type="text" class="form-control" placeholder="请输入栏目标题" />
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn zd_btn3" onclick="queding()">
                    确定
                </button>
                <button class="btn btn-danger" data-dismiss="modal">
                    取消
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function delpic(){
        var chk_value =[];
        $('#tupian input[type=checkbox]:checked').each(function(){ //jquery获取复选框值
            chk_value.push($(this).val());
        });
        num = $('input:checked').length;
        if(num==0){
            alert('请选择您要删除的图片');
            return false;
        }
        if(window.confirm("你确定要删除这张图片么")){
            var url = "/manage/dellunbo";
            var formdata = {};
            formdata.chk_value = chk_value;
            $.post(url,formdata).done(function (data){
                if (data.status == 0){
                    alert("删除成功");
                    window.location.reload();
                }else {
                  alert("删除失败");
                }
            });
        }      
    }

    function edit(t){
        var id = $(t).attr('id');
        var name = $(t).val();
        $("#editcol").val(name);
        $("#editcol").attr('name',id);
    }
//编辑栏目标题
    function queding(){
        var url = "/manage/editcolumn";
        var formdata = {};
        formdata.id = $("#editcol").attr('name');
        formdata.name = $("#editcol").val();
        $.post(url,formdata).done(function (data){
            if (data.status == 0){
                alert("修改成功");
                window.location.reload();
            }else {
                alert("修改失败");
            }
        });
    }
    //删除栏目
    function delColname(t){
        if(window.confirm("确定要删除该栏目？")){
            var url = "/manage/delcolumn";
            var formdata = {};
            formdata.id = $(t).attr('id');
            $.post(url,formdata).done(function (data){
                if (data.status == 0){
                    alert("删除成功");
                    window.location.reload();
                }else {
                    alert("删除失败");
                }
            });
        }
    }

    //新增栏目
    function addcol(){
        var url ="/manage/addcolumn";
        var formdata={};
        formdata.name = $("#addtitle").val();
        if(formdata.name ==""){
            alert("栏目名称不能为空");
            return false;
        }
        $.post(url,formdata).done(function(data){
            if (data.status == 0){
                alert("添加成功");
                window.location.reload();
            }else {
                alert("添加失败");
            }
        });
    }
</script>


