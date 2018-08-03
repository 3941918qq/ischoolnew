<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ZfProvince;
use common\models\ZfCity;
use common\models\ZfCounty;
use common\models\ZfSchoolType;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\ZfSchool */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="zf-school-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php if($model->isNewRecord){ ?>
            <?= $form->field($model, 'pro_id')->dropDownList(
                ZfProvince::find()
                ->select(['name','id'])
                ->indexBy('id')
                ->column(),
                ['prompt'=>'请选择省份','id'=>"pro-id"])->label("省份"); ?>
           <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
                'options' => ['id'=>'city-id','prompt'=>'请选择'],
                'pluginOptions'=>[
                        'depends'=>['pro-id'],
                        'url' => Url::to(['/base/citys'])
                ]
            ])->label("城市");?>
           <?= $form->field($model, 'county_id')->widget(DepDrop::classname(), [
                'options' => ['id'=>'country-id','prompt'=>'请选择'],
                'pluginOptions'=>[
                        'depends'=>['city-id'],
                        'url' => Url::to(['/base/countys'])
                ]
 	    ])->label("县区");?>
    <?php }else{ ?>
           <?= $form->field($model, 'pro_id')->dropDownList(
                ZfProvince::find()
                ->select(['name','id'])
                ->indexBy('id')
                ->column(),
                ['prompt'=>'请选择省份','id'=>"pro-id",'readonly'=>'readonly'])->label("省份"); ?>
            <?=$form->field($model, 'city_id')->dropDownList( ZfCity::find()
                ->select(['name','id'])
                ->indexBy('id')
                ->column(),
                ['readonly'=>'readonly']
                )->label("城市"); ?>
            <?= $form->field($model, 'county_id')->dropDownList( ZfCounty::find()
                ->select(['name','id'])
                ->indexBy('id')
                ->column(),
                ['readonly'=>'readonly']
                )->label("县区"); ?>
    
    <?php }?>
    

    <?= $form->field($model, 'sch_type')->dropDownList(
            ZfSchoolType::find()
            ->select(['name','id'])
            ->indexBy('id')
            ->column(),
            ['prompt'=>'请选择学校类型']
            )->label("学校类型"); ?>

    <?= $form->field($model, 'setting')->textInput(['maxlength' => true])->label("设置"); ?>

    <?= $form->field($model, 'ckpass')->dropDownList([ 1 => '开启', 0 => '关闭', ], ['prompt' => '请选择'])->label("餐卡状态") ?>

    <?= $form->field($model, 'skpass')->dropDownList([ 1 => '开启', 0 => '关闭', ], ['prompt' => '请选择'])->label("水卡状态") ?>

    <?= $form->field($model, 'papass')->dropDownList([ 1 => '开启', 0 => '关闭', ], ['prompt' => '请选择'])->label("平安通知状态") ?>

    <?= $form->field($model, 'jxpass')->dropDownList([ 1 => '开启', 0 => '关闭', ], ['prompt' => '请选择'])->label("家校沟通状态") ?>

    <?= $form->field($model, 'qqpass')->dropDownList([ 1 => '开启', 0 => '关闭', ], ['prompt' => '请选择'])->label("亲情电话状态") ?>

    <?= $form->field($model, 'xfpass')->dropDownList([ 1 => '开启', 0 => '关闭', ], ['prompt' => '请选择'])->label("学费状态") ?>

    <?= $form->field($model, 'month_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'half_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_youhui')->dropDownList([ 1 => '优惠', 0 => '无优惠', ], ['prompt' => '请选择'])->label("是否有优惠活动") ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
