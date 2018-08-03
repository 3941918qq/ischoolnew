<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfSuggest */

$this->title = '信息更新' ;
$this->params['breadcrumbs'][] = ['label' => '意见反馈', 'url' => ['index']];
$this->params['breadcrumbs'][] = '信息更新';
?>
<div class="zf-suggest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
