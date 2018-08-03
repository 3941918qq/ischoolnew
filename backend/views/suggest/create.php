<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZfSuggest */

$this->title = 'Create Zf Suggest';
$this->params['breadcrumbs'][] = ['label' => 'Zf Suggests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-suggest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
