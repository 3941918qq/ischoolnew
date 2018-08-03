<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfParentStudent */

$this->title = 'Create Zf Parent Student';
$this->params['breadcrumbs'][] = ['label' => 'Zf Parent Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-parent-student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
