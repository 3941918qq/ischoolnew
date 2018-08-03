<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ZfSchool */

$this->title = '学校更新';
$this->params['breadcrumbs'][] = ['label' => '学校管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '学校更新';
?>
<div class="zf-school-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
