<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfSchool */

$this->title = '添加学校';
$this->params['breadcrumbs'][] = ['label' => '学校管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加学校';
?>
<div class="zf-school-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
