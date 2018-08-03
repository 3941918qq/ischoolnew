<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ZfProvince;
use common\models\ZfCity;
use common\models\ZfCounty;
use common\models\ZfSchoolType;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZfSchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学校管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zf-school-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建学校', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <?= Html::a('导出', [strpos(\yii::$app->request->url,"?")>-1? \yii::$app->request->url.'&type=export':\yii::$app->request->url.'?type=export'], ['class' => 'btn btn-danger pull-right','target'=>"_blank"]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            // 'id', 
            ['attribute'=>'id',
            'contentOptions'=>['width'=>'120px'],
            ],       
            //'pro_id',
            ['label'=>'省份',
             'attribute'=>'pro_id',
             'value'=>'pro.name',
             'filter'=>ZfProvince::find()
                        ->select(['name','id'])
                        ->indexBy('id')
                        ->column()
            ],  
            ['label'=>'城市',
             'attribute'=>'city_id',
             'value'=>'city.name',
             'filter'=>ZfCity::find()
                        ->select(['name','id'])
                        ->indexBy('id')
                        ->column()
            ],
            ['label'=>'县区',
             // 'attribute'=>'county_id',
             'attribute'=>'county_name',
             'value'=>'county.name',
             // 'filter'=>ZfCounty::find()
             //            ->select(['name','id'])
             //            ->indexBy('id')
             //            ->column()
            ],
            ['label'=>'学校类型',
             'attribute'=>'sch_type',
             'value'=>'schType.name',
             'filter'=>ZfSchoolType::find()
                        ->select(['name','id'])
                        ->indexBy('id')
                        ->column()
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                    
            ],
        ],
    ]); ?>
</div>
