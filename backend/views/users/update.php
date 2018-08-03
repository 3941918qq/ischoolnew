<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfUser */

$this->title = '更新用户信息';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新用户信息';
?>
<div class="zf-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
