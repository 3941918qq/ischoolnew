<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfOrder */

$this->title = 'Create Zf Order';
$this->params['breadcrumbs'][] = ['label' => 'Zf Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
