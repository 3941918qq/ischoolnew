<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <div class="clearfix">
            <h4 class="pull-left">班级列表</h4>         
        </div>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'班级名称',
                'attribute'=>'name'
            ],
            [
                'label'=>'班',
                'attribute'=>'banji',
                'value'=>function($model){
                     $arr=$model->getClassnumber();
                     return $arr["$model->class"]."班";
                }
            ],
            [
                'label'=>'年级',
                'attribute'=>'nianji',
                'value'=>function($model){
                     $arr=$model->getLevel();
                     return $arr["$model->level"];
                }
            ],
            [
                'attribute'=>'class_teacher',
                'label'=>'班主任',
                'value'=>function($model){
                    return $model->getT($model->id) ;                                     
                }
                
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{config} {safe-info} {leave} ',
            'header'=>'操作',
                'buttons'=>[
                    'config'=>function($url,$model,$key){
                           return \yii\bootstrap\Html::a("配置教师",'#',[
                          'data-toggle'=>'modal' ,'data-target'=>'#configModal'.$model->id,
                          'onclick'=>'hiddenId(this)',
                          'data'=>$model->id]);  
                    },
                    'safe-info'=>function($url,$model,$key){
                           return \yii\bootstrap\Html::a("考勤信息",Url::to("/manage/safe-info?id=".$model->id.'&class='.$model->name));  
                    },
                     'leave'=>function($url,$model,$key){
                           return \yii\bootstrap\Html::a("请假信息",Url::to("/manage/leave?id=".$model->id.'&class='.$model->name)); 
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
            'id'=>'Config-Teacher',
            'options' => ['class' => 'modal-content form-horizontal'],
            'fieldConfig' => [
                    'template' => ' <label class="col-sm-4 control-label" for="pwd">{label}:</label>
                                      <div class="col-sm-6">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                   'inputOptions' => ['class' => 'form-control'],
                 ],
            ]); ?>
            <div class="modal-header">
                配置老师
            </div>
            <div class="modal-body">
                <input id="add_c_id" name="ConfigTeacher[id]" value="" type="hidden">
                <?= $form->field($model, 'role_id',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList(
                      $model->role )->label('分配角色'); ?>
                <?= $form->field($model, 'course_id',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList(
                      $model->course )->label('学科'); ?>
                <?= $form->field($model, 't_id',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList($model->alltea)->label('老师'); ?>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-8">
                       <?= Html::submitButton('配置', ['class' => 'form-control btn-success']) ?>
                    </div>
                </div>
            </div>    
        <?php ActiveForm::end(); ?>                  
    </div>
</div>
<script type="text/javascript">
    function hiddenId(obj){
        var id=$(obj).attr('data');
        var v='configModal'+id;
        $(".appmotai").attr('id',v);
        $("#add_c_id").val(id);      
    }

</script>