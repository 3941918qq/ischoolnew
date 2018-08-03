<?php
/* @var $this \yii\web\View */
/* @var $content string */
use mobile\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
AppAsset::register($this); 
AppAsset::addCss($this ,'@web/css/home-css.css');
AppAsset::addScript($this ,'@web/js/css3-mediaqueries.js');
AppAsset::addScript($this ,'@web/js/Headroom.js');
AppAsset::addScript($this ,'@web/js/unslider.js');
AppAsset::addScript($this ,'@web/js/home-js.js');

// $this->registerCssFile('@web/css/font-awesome.min.css',['depends'=>['backend\assets\AppAsset']]); 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="body-color">
<?php $this->beginBody() ?>

<?= $content ?>

<?= $this->render('footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
