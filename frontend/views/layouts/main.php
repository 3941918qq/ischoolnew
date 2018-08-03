<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\MenuWidget;
use frontend\components\ToggleRoleWidget;
use frontend\components\ToggleWidget;
AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <title>正梵智慧校园</title> 
    <link rel="shortcut icon" href="/img/0206_08.png">
    <?= Html::csrfMetaTags() ?>    
    <link rel="stylesheet" href="/css/mystyle.css" />
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <?php $this->head() ?>
    <script type="text/javascript" src="/js/jquery-1.12.3.js" ></script>
    <script type="text/javascript" src="/js/bootstrap.min.js" ></script>
    <script type="text/javascript" charset="utf-8" src="/js/Text_editing/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/Text_editing/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/Text_editing/lang/zh-cn/zh-cn.js"></script>
    <style type="text/css">
    .slide{position: relative; overflow: hidden;max-height:250px;}
    .slide img{max-width: 100%; position: absolute; left: 0; top: 0;}
    .slide img:first-child{position: relative; visibility: visible;}
    </style>
    <script type="text/javascript" src="/rili/jedate/jedate.js" ></script>
</head>
<body>
 <?php $this->beginBody() ?>
<div id="tophead">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6">欢迎使用正梵智慧校园</div>
            <div class="col-xs-12 hidden-xs col-sm-6 text-right">服务热线：0371-55030687</div>
        </div>
    </div>
</div>
<div>
    <div class="container" style="line-height: 60px;">
        <img src="../img/0208_04.png" /><span style="font-size: 20px;margin: 0 10px;">|</span>
        <?= ToggleRoleWidget::widget(['toggleRole'=>$toggleRole]);?>
        
        <div class="dropdown pull-right">
            <?= ToggleWidget::widget(['toggle'=>$toggle]);?>
            <div class="pull-right" style="padding-left: 10px;">               
                <a style="color: black;font-size: 14px;padding-left: 10px;" href="###">帮助中心</a>
                <a style="color: black;font-size: 14px;padding-left: 20px;" href="###">关于我们</a>
                <a style="color: black;font-size: 14px;padding-left: 20px;" href="/index/logout">退出</a>
            </div>
        </div>
    </div>
</div>
    
<div style="background-color: #f4f4f6;padding: 40px;min-height: 650px;">
    <div class="container" style="font-size:1.3rem;">
            <?= MenuWidget::widget(['menu'=>$menu]);?>

       
            <?= $content ?>
        
     </div>  
    <div class="text-center" style="line-height: 30px;color: #98999b;">
        Copyright @ 河南正梵通信技术有限公司 All rights reserved 豫ICP备13024673<br />
        <img src="/img/0206_88.png" />豫公网安备 41010502002379
    </div>
</div>
<?php $this->endBody() ?>   
</body>
</html>
<script type="text/javascript">
$(".panel-body img").css({"max-width":"100%"})
//切换身份
function changeRole(t){
    var formdata = {};
    formdata.role = t.id;
    formdata.uid = t.name;
    var url = "/index/toggle-role";
    if(confirm("您确定切换身份？")) {
        $.post(url, formdata).done(function (data) {
            if (data.status == '0') {
                 alert("身份切换成功");
                window.location.href = data.url;
            } else {
                alert("身份切换失败，请联系客服人员处理");
            }
        });
    }
}
//切换
function change(t){
    var formdata = {};   
    if(t.name=='parent'){
        formdata.last_stuid = t.id;      
    }else{
        formdata.last_sid = t.id;
    }
    formdata.uid = t.getAttribute("data");
    formdata.type = t.name;
    var url = "/index/toggle";
    if(confirm("您确定切换身份？")) {
        $.post(url, formdata).done(function (data) {
            if (data.status == '0') {
                 alert("切换成功");
                window.location.href ='myinfo';
            } else {
                alert("切换失败，请联系客服人员处理");
            }
        });
    }
}

var size = $('.slide img').size();
var _index = size;
var timer = null;
 $('.slide').append($('.slide img:eq(0)').clone());
  timer = setInterval(function(){
    $('.slide img').eq(_index).fadeOut(1500);
    _index == 1?_index=size:_index--;
    $('.slide img').eq(_index).fadeIn(1500);
  },4000);
</script>
<?php $this->endPage() ?>

