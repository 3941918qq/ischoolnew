<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>正梵智慧校园</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
if(!yii::$app->user->isGuest) {
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
//    $menuItems = [
//        ['label' => 'Home', 'url' => ['/site/index']],
//    ];
    $menuItems = [
        ['label' => '学校管理', 'items' => [
            ['label' => "学校信息", 'url' => '/school/index'],
            ['label' => "班级信息", 'url' => '/class/index']
        ]],
        ['label' => '学生管理', 'items' => [
            ['label' => "学生管理", 'url' => '/student/index'],
            ['label' => "刷卡信息", 'url' => '/safecard/index'],
        ]],
        ['label' => '教师管理', 'items' => [
            ['label' => "教师管理", 'url' => '/teacher/index'],
        ]],
        ['label' => '家长管理', 'items' => [
            ['label' => "家长管理", 'url' => '/parent/index'],
        ]],
        ['label' => "用户管理", 'url' => '/users/index'],
        ['label' => '订单管理', 'items' => [
            ['label' => "订单信息", 'url' => '/order/index'],
        ]],
        ['label' => '数据查询', 'items' => [
            ['label' => "整体信息", 'url' => '/query/index'],
            ['label' => "卡库信息", 'url' => '/card/index'],
            ['label' => "分类信息", 'url' => '/query/wbdrs'],
            ['label' => "意见反馈", 'url' => '/suggest/index']
        ]],
        ['label' => '数据导入', 'url' => '/import/index'],

        ['label' => '设备状态', 'items' => [
            ['label' => "平安通知", 'url' => '/query/newsbzt'],
            ['label' => "平安汇总", 'url' => '/query/newsbxx'],
            ['label' => "亲情电话", 'url' => '/query/newqqzt'],
            ['label' => "亲情汇总", 'url' => '/query/newqqxx']
        ]],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/user/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '退出 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';

    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
}
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink'=>false
            ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-center">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

<!--        <p class="pull-right"><?= Yii::powered() ?></p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
