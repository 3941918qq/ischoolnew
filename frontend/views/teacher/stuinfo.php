<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <div class="clearfix">
            <h4 class="pull-left">学生信息</h4>
        </div>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute'=>'name',
              'label'=>'姓名'
            ],
            [
              'attribute'=>'stu_no',
              'label'=>'学号'
            ],
            [
              'attribute'=>'class',
              'value'=>'class.name',
              'label'=>'班级',
            ],
            [
               'attribute'=>'isband',
               'label'=>'是否绑定',
               'filter'=>['0'=>'未绑定','1'=>'已绑定'],
               'value'=>function($model){
                    return ($model::getCheckBind($model->id)==1) ?'已绑定':'未绑定';
                },
               'contentOptions'=>function($model){
                    return ($model::getCheckBind($model->id)==1) ?'':['style'=>'background-color:#ddd;width:73px;'];
               }
            ],

            [
             'class' => 'yii\grid\ActionColumn',
              'header'=>'操作',
              'template'=>' {bind}  {lxr}  {leave}',
              'buttons'=>[
                   'bind'=>function($url,$model,$key){
                        return \yii\bootstrap\Html::a("<span  class='glyphicon glyphicon-plus-sign'></span>",'#',[
                          'data-toggle'=>'modal' ,'data-target'=>'#tjlxModal'.$model->id,
                          'onclick'=>'hiddenId(this)',
                          'data'=>$model->id]);
                   },
                   'lxr'=>function($url,$model,$key){
                        $arr=array();
                        foreach($model->zfFamilyNumbers as $k=>$value){
                            $arr[$k]['relation']=$value->attributes['relation'];
                            $arr[$k]['tel']=$value->attributes['tel'];
                        }
                        return \yii\bootstrap\Html::a("<span class='glyphicon glyphicon-user'></span>",'#',[
                           'data-toggle'=>'modal' ,'data-target'=>"#lxModal",  
                           'onclick'=>"lxrcx(this)",
                           'data'=>json_encode($arr)]);                       
                    },
                   'leave'=>function($url,$model,$key){
                        return \yii\bootstrap\Html::a("请假",'#',[
                             'data-toggle'=>'modal' ,'data-target'=>"#qjModal",
                            'onclick'=>"doqingjia(this)",
                            'data'=>$model->id
                        ]);
                   }
              ]
            ],
        ],
    ]);
    ?>
    </div>
</div>
</div>
</div>

<!--添加联系人id="tjlxModal3"-->
<div class="modal fade lxrmotai" >
    <div class="modal-dialog">
         <?php $form = ActiveForm::begin([
            'id'=>'Add-Lxr',
            'options' => ['class' => 'modal-content form-horizontal'],
            'fieldConfig' => [
                    'template' => ' <label class="col-sm-4 control-label" for="pwd">{label}:</label>
                                      <div class="col-sm-6">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                   'inputOptions' => ['class' => 'form-control'],
                 ],
            ]); ?>
            <div class="modal-header">
                添加联系人
            </div>
            <div class="modal-body">
                <input id="add_stu_id" name="AddLxr[stuid]" value="" type="hidden">
                <?= $form->field($model, 'relation',['labelOptions' => ['class' => 't-r-pd5']])->textInput()->label('身份'); ?>
                <?= $form->field($model, 'tel',['labelOptions' => ['class' => 't-r-pd5']])->textInput()->label('手机号'); ?>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-8">
                       <?= Html::submitButton('添加', ['class' => 'form-control btn-success']) ?>
                    </div>
                </div>
            </div>    
        <?php ActiveForm::end(); ?>                            
    </div>
</div>

<!--联系人-->
<div class="modal fade" id="lxModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                联系人
                <button class="close" data-dismiss="modal" >
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-center" style="margin-top: 20px;" id="lxrxx">
                    <tr style="background-color: #eee;">
                        <td>身份</td>
                        <td>电话</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" >
                    确定
                </button>
            </div>
        </div>
    </div>
</div>
<!--请假-->
<div class="modal fade" id="qjModal">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="/teacher/doleave" id="formqj">
            <div id="formqjhd"></div>
            <div class="modal-header">
                请假
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <for class="modal-body">
                <table class="table">
                    <tr>
                        <td>开始时间：</td>
                        <td>
                            <input class="form-control"  id="kq_date_from" type="text" placeholder="请选择" name="statime" value="" readonly />
                        </td>
                        <td>结束时间：</td>
                        <td>
                            <input class="form-control"  id="testy2" type="text" placeholder="请选择" name="endtime" value="<?php echo date('Y-m-d 23:59:59', time());?>" readonly />
                        </td>
                    </tr>
                    <tr>
                        <td>请假原因：</td>
                        <td colspan="4">
                            <textarea cols="60" rows="6" name="reason"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input class="btn btn-success" type="submit" onclick="return qingjia(this)"/>
                        </td>
                        <input type='hidden' value="tea" name='shenfen'>
                        <td id="thisid">

                        </td>
                    </tr>
                </table>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    // 请假信息
    function qingjia(t){
        var formdata={};
        formdata.statime = $(t).parents("tbody").find('input[name="statime"]').val();
        formdata.endtime = $(t).parents("tbody").find('input[name="endtime"]').val();
        formdata.reason = $(t).parents("tbody").find('textarea[name="reason"]').val();
        statime= Date.parse(new Date(formdata.statime));
        endtime = Date.parse(new Date(formdata.endtime));
        if(statime>=endtime){
            alert("开始时间不能大于或等于结束时间");
            return false;
        }
        var reason = $.trim(formdata.reason);
        if(reason ==""){
            alert("请假原因不能为空");
            return false;
        }
    }
    jeDate({
        dateCell:"#kq_date_from",
        format:"YYYY-MM-DD hh:mm:ss",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"2011-09-19 00:00:00",
        okfun:function(val){}
    })
    jeDate({
        dateCell:"#testy2",
        format:"YYYY-MM-DD hh:mm:ss",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"2011-09-19 00:00:00",
        okfun:function(val){}
    })


    function hiddenId(obj){
        var id=$(obj).attr('data');
        var v='tjlxModal'+id;
        $(".lxrmotai").attr('id','tjlxModal'+id);
        $("#add_stu_id").val(id);
        $("#add_stu_id").hidden();
      
    }
    function lxrcx(obj){
        var json=$(obj).attr('data');
        var myobj=eval(json);
        var html="<tr style='background-color: #eee;'><td>身份</td><td>电话</td></tr>";
        for(var i=0;i<myobj.length;i++){  
             html +="<tr id='lxrid'><td>"+myobj[i].relation +"</td><td>"+ myobj[i].tel+"</td></tr>";       
        }  
        $("#lxrxx").html(html);
       
    }

    function doqingjia(obj){
        var json=$(obj).attr('data');
        var html="<input type=      'hidden' value="+json+" name='stu_id'>";
        $("#thisid").html(html);
    }
</script>
