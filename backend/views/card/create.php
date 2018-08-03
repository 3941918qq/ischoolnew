<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfCardLibrary */

$this->title = 'Create Zf Card Library';
$this->params['breadcrumbs'][] = ['label' => 'Zf Card Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-card-library-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
