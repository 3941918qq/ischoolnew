<?php
use mobile\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
AppAsset::register($this);
AppAsset::addCss($this ,'@web/css/tongzhi.css');
AppAsset::addCss($this ,'@web/css/index-columns.css');
AppAsset::addCss($this ,'@web/css/home-css.css');
AppAsset::addCss($this ,'@web/css/user-css.css');
AppAsset::addCss($this ,'@web/css/font-awesome.min.css');
AppAsset::addCss($this ,'@web/css/ui-dialog.css');
AppAsset::addScript($this ,'@web/js/css3-mediaqueries.js');
AppAsset::addScript($this ,'@web/js/ajaxload.js');
AppAsset::addScript($this ,'@web/js/dialog-min.js');
AppAsset::addScript($this ,'@web/js/myDialog.js');
AppAsset::addScript($this ,'@web/js/LocalResizeIMG.js');
AppAsset::addScript($this ,'@web/js/mobileBUGFix.mini.js');
AppAsset::addScript($this ,'@web/js/manage.js');
$this->title='我的资料';
?>
<?php $this->beginPage() ?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<style>

    .page{
        display: block;
    }
    .page-off{
        display: none;
    }
    .off{
        display: none;
    }
    .on{
        display: block;
    }
    
</style>
</head>
<body class="body-color">
 <?php $this->beginBody() ?>
    
  <?= $content ?>
    
  <?= $this->render('footer') ?>
  
 <?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>
