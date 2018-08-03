<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <?php $form=ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
    <div style="background-color: white;padding: 10px 20px;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left"><?= $ischool ?></h4>
            <div class="col-sm-2 col-sm-offset-10">
              <?= Html::submitButton('发布', ['class' => 'form-control btn-success pull-right']) ?>
            </div>
        </div>
        <hr/>
        <p class="text-primary row" style="margin-bottom: 10px;">
            <span class="badge col-lg-1" style="background: red;padding: 3px 10px">标题</span>
            <span class="col-lg-1"></span>
            <span class="col-lg-10">
                    <input style="margin-top: -10px;margin-bottom: 10px;" class="form-control" placeholder="请输入主题信息" name="Column[title]" id="title" value="<?= $data['title']?>"/>
            </span>
        </p>
        <p class="text-primary row">
            <span class="badge col-lg-1" style="background: red;padding: 3px 10px">简介</span>
            <span class="col-lg-1"></span>
            <span class="col-lg-10">
                    <input style="margin-top: -10px;margin-bottom: 10px;" class="form-control" placeholder="请输入简介" name="Column[sketch]" id="sketch" value="<?= $data['sketch']?>"/>
            </span>
        </p>
        <div>
            <script id="editor" type="text/plain" name="Column[content]"  style="width:100%;height:350px;"><?= (isset($data)) ? $data['content']:'';?></script>
        </div>
    </div>
    <div class="clearfix" style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
        <div class="zt_img pull-left" >
            <div id="loading" class="ui-dialog-loading" style="margin-top:10px;display:none">Loading..</div>
            <img style="max-width: 300px;" src="<?= ($data['columnPicture'])?:"/img/zhuti.JPG"?>" id="img"/>
        </div>
        <?= $form->field($model, 'columnPicture',['labelOptions' => ['class' => 'btn','style'=>'background-color: #36ADFF;margin-left: 20px;color: white;'],'inputOptions'=>['style'=>'display:none;','id'=>'imgInp']])->fileInput()->label('上传封面') ;?> 
    </div>   
    <?php ActiveForm::end() ?>
</div>
</div>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function(){
        readURL(this);
    });
    var ue = UE.getEditor('editor');
    function isFocus(e) {
        alert(UE.getEditor('editor').isFocus());
        UE.dom.domUtils.preventDefault(e)
    }
    function setblur(e) {
        UE.getEditor('editor').blur();
        UE.dom.domUtils.preventDefault(e)
    }
    function insertHtml() {
        var value = prompt('插入html代码', '');
        UE.getEditor('editor').execCommand('insertHtml', value)
    }
    function createEditor() {
        enableBtn();
        UE.getEditor('editor');
    }
    function getAllHtml() {
        alert(UE.getEditor('editor').getAllHtml())
    }
    function getContent() {
        var arr = [];
        arr.push(UE.getEditor('editor').getContent());
        return arr.join("\n");
    }
    function getPlainTxt() {
        var arr = [];
        arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getPlainTxt());
        alert(arr.join('\n'))
    }
    function setContent(params,isAppendTo) {
        var arr = [];
        UE.getEditor('editor').setContent(params, isAppendTo);
    }
    function setDisabled() {
        UE.getEditor('editor').setDisabled('fullscreen');
        disableBtn("enable");
    }
    function setEnabled() {
        UE.getEditor('editor').setEnabled();
        enableBtn();
    }
    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range = UE.getEditor('editor').selection.getRange();
        range.select();
        var txt = UE.getEditor('editor').selection.getText();
        alert(txt)
    }
    function getContentTxt() {
        var arr = [];
        arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
        arr.push("编辑器的纯文本内容为：");
        arr.push(UE.getEditor('editor').getContentTxt());
        alert(arr.join("\n"));
    }
    function hasContent() {
        var arr = [];
        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
        arr.push("判断结果为：");
        arr.push(UE.getEditor('editor').hasContents());
        alert(arr.join("\n"));
    }
    function setFocus() {
        UE.getEditor('editor').focus();
    }
    function deleteEditor() {
        disableBtn();
        UE.getEditor('editor').destroy();
    }
    function disableBtn(str) {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for(var i = 0, btn; btn = btns[i++];) {
            if(btn.id == str) {
                UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
            } else {
                btn.setAttribute("disabled", "true");
            }
        }
    }
    function enableBtn() {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for(var i = 0, btn; btn = btns[i++];) {
            UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
        }
    }
    function getLocalData() {
        alert(UE.getEditor('editor').execCommand("getlocaldata"));
    }
    function clearLocalData() {
        UE.getEditor('editor').execCommand("clearlocaldata");
        alert("已清空草稿箱")
    }
</script>


