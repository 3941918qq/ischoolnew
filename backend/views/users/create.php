<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfUser */

$this->title = 'Create Zf User';
$this->params['breadcrumbs'][] = ['label' => 'Zf Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
