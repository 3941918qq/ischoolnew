<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <div class="clearfix">
            <h4 class="pull-left">所有教师</h4>
         
        </div>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
               'attribute'=>'name',
               'label'=>'姓名',
               'value'=>'t.name'
            ],
            [
               'attribute'=>'course',
               'label'=>'学科',
               'value'=>'course.name'
            ],
            [
               'attribute'=>'class',
               'label'=>'班级',
               'value'=>'c.name'
            ],
            [
               'attribute'=>'role',
               'label'=>'角色',
               'value'=>'role.name'
            ],           
            [
               'attribute'=>'ispass',
               'label'=>'是否审核',
               'filter'=>['0'=>'待审核','1'=>'已审核'],
               'value'=>function($model){
                    return ($model->ispass==1) ?'已审核':'待审核';
                },
                'contentOptions'=>function($model){
                    return ($model->ispass==0) ? ['class'=>'bg-danger'] :'';
                }
            ],
            [
               'attribute'=>'tel',
               'label'=>'电话',
               'value'=>'t.tel'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{approve} {delete} ',
                'header'=>'操作',
                'buttons'=>[
                    'approve'=>function($url,$model,$key){
                           return \yii\bootstrap\Html::a("<span  class='glyphicon glyphicon-check'></span>",'#',[
                          'data-toggle'=>'modal' ,'data-target'=>'#approveModal'.$model->id,
                          'onclick'=>'hiddenId(this)',
                          'data'=>$model->id]);  
                    }
                ]
            ],
        ],       
    ]); ?>
    </div>
</div>

<!--添加联系人id="tjlxModal3"-->
<div class="modal fade appmotai" >
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin([
            'id'=>'Approve-Teacher',
            'options' => ['class' => 'modal-content form-horizontal'],
            'fieldConfig' => [
                    'template' => ' <label class="col-sm-4 control-label" for="pwd">{label}:</label>
                                      <div class="col-sm-6">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                   'inputOptions' => ['class' => 'form-control'],
                 ],
            ]); ?>
            <div class="modal-header">
                审核操作
            </div>
            <div class="modal-body">
                <input id="add_stu_id" name="ApproveTeacher[id]" value="" type="hidden">
                <?= $form->field($model, 'role_id',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList(
                      $model->role )->label('分配角色'); ?>
                <?= $form->field($model, 'ispass',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList(['0'=>'待审核','1'=>'已审核'])->label('状态'); ?>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-8">
                       <?= Html::submitButton('审核', ['class' => 'form-control btn-success']) ?>
                    </div>
                </div>
            </div>    
        <?php ActiveForm::end(); ?>                  
    </div>
</div>

<script type="text/javascript">
    function hiddenId(obj){
        var id=$(obj).attr('data');
        var v='approveModal'+id;
        $(".appmotai").attr('id',v);
        $("#add_stu_id").val(id);      
    }

</script>
