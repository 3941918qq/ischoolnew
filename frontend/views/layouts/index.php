<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="/img/0206_08.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>正梵智慧校园</title>
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/mystyle.css" />
    <script type="text/javascript" src="/js/jquery-1.12.3.js" ></script>
    <script type="text/javascript" src="/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="/rili/jedate/jedate.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            min-width:1300px;
    </style>
</head>
<body>
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
        <img src="/img/0208_04.png" />
        <div class="pull-right lg_nav">
            <a href="/site/bdxs" target="_blank">绑定学生</a>
        </div>
    </div>
</div>

<?php $this->beginBody() ?>
        <?= $content ?>
<?php $this->endBody() ?>
        <div class="text-center" style="line-height: 30px;color: #98999b;">
            Copyright @ 河南正梵通信技术有限公司 All rights reserved
            <a target="_blank" style="color:#888" href="http://www.miitbeian.gov.cn/">豫ICP备13024673号-2</a><br />
            <img src="/img/0206_88.png" /><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=41010502002679" target="_blank" style="color:#888">豫公网安备 41010502002679号</a>
        </div>
</body>
</html>

<?php $this->endPage() ?>


