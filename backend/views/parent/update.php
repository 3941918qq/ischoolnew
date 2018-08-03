<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfParentStudent */

$this->title = '更新家长';
$this->params['breadcrumbs'][] = ['label' => '家长管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新家长';
?>
<div class="zf-parent-student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
