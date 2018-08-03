<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfCardLibrary */

$this->title = '更新EPC电话卡 ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '卡库信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新EPC电话卡';
?>
<div class="zf-card-library-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
