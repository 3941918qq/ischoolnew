<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style type="text/css">
    .modal-content{width: 1200px;margin-left: -300px;}
</style>

        <div class="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;">
            <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <h4>学生信息</h4>
        <div class="media" style="border: 1px solid #ccc;padding: 20px;">
            <a href="###" class="pull-left">
                <img src="../img/pc_ren.png" />
            </a>
            <table class="media-body" style="line-height: 30px;padding-left: 30px;">
                <tr>
                    <td>学生：</td>
                    <td><?=$data['stu_name'];?></td>
                </tr>
                <tr>
                    <td>学校：</td>
                    <td><?=$data['school'];?></td>
                </tr>
                <tr>
                    <td>班级：</td>
                    <td><?=$data['class'];?></td>
                </tr>
                <tr>
                    <td>班主任：</td>
                    <td><?=$data['tea_name'];?></td>
                </tr>
                <tr>
                    <td>手机号：</td>
                    <td><?=$data['tel'];?></td>
                </tr>
            </table>
        </div>

            <form style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;" method="post" action="/parent/leave">
                <h4>申请请假</h4>
                <table class="table" border="0">
                    <tr>
                        <td>开始时间：</td>
                        <td>
                            <input type="hidden" value="<?=$data['stu_id'];?>" name="stu_id">
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
<!--                            <input type="button" value="保存" class="save_button">-->
                            <input class="btn btn-success" type="submit" value="提交" onclick="return qingjia(this)"/>
                        </td>
                    </tr>
                </table>
            </form>

            <?php if(isset($data['stuleave']) && ($data['stuleave']!="")){ foreach($data['stuleave'] as $list){
                ?>
                <div style="background-color: #ffffed;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
                    <img src="../img/pc_dng.png" />
                    <span style="vertical-align: middle;padding-left: 5px;">
            <?php if($list['flag'] ==2){echo $list['name']."申请".$list['startTime']."至".$list['endTime']."请假信息待审核！";}if($list['flag'] ==1){
                echo $list['name']."申请的".$list['startTime']."至".$list['endTime']."请假信息已通过！";} ?>
                        <?php if($list['flag'] ==3){echo $list['name']."申请的".$list['startTime']."至".$list['endTime']."请假信息已被拒绝！";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/parent/qqbxs?id=<?=$list['id']?>" >不再显示</a><?php } ?>
        </span>
                </div>
            <?php  }}?>

            <form style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
                <h4>成绩查询</h4>
                <table class="table">
                    <tr>
                        <td style="vertical-align: middle;">考&nbsp;&nbsp;&nbsp;&nbsp;试：</td>
                        <td>
                            <select class="form-control" name="cjd">
                                <?php foreach($data['chengji'] as $chegnji){?>
                                    <option value="<?=$chegnji['cjid']?>" id="<?=$chegnji['isopen']?>"><?=$chegnji['name']?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="vertical-align: middle; width: 60px;text-align: right;">学&nbsp;&nbsp;&nbsp;&nbsp;生：</td>
                        <td>
                            <select class="form-control" name="stu_name">
                                <option value="all">全部</option>
                                <option value="<?=$data['stu_id']?>"><?=$data['stu_name'];?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input class="btn btn-success" type="button" data-toggle="modal" data-target="#cjModal" id="" value="提交" onclick="return chengji(this)"/>
                        </td>
                    </tr>
                </table>
            </form>

    </div>
        </div>
<!--成绩查询-->
<div class="modal fade" id="cjModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                成绩查询
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">
                    确定
                </button>
            </div>
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

    function chengji(t){
        var url = "/parent/doscorequery";
        var formdata={};
        formdata.cjdid = $('select[name="cjd"] option:selected').val();
        formdata.stuid = $('select[name="stu_name"] option:selected').val();
        formdata.isopen = $('select[name="cjd"] option:selected').attr("id");
        formdata.cid = <?php echo $data['class_id'];?>;
        $(t).attr("data-toggle","modal");

        if (formdata.isopen == "0" && formdata.stuid =="all"){
            alert("该班级成绩没有公开，不能查询全部成绩");
            $(t).attr("data-toggle","");
            return false;
        }
        if (formdata.cjdid == undefined || formdata.cjdid == ""){
            alert("请选择成绩单");
            $(t).attr("data-toggle","");
            return false;
        }else {
            $.post(url,formdata).done(function(data){

                data = $.parseJSON(data);
                // alert(data[0]);

                if(data != null){
                    var htmls = "<tr>";
                    var title = data[0];  //第0行标题行
                    var cols = title.length;
                    var t = 0;
                    for(t;t < cols;t++){
                        htmls = htmls + "<td>"+title[t]+"</td>";
                        if(t == cols-1){
                            htmls = htmls + "</tr>";
                        }
                    }

                    var content = data[1]; //内容行
                    var rows = content.length;
                    var i = 0;
                    for(i;i < rows;i++){
                        var j = 0;
                        var row = content[i];
                        for(j;j < cols;j++)
                        {
                            if(j == 0){
                                htmls = htmls + "<tr>";
                            }
                            htmls = htmls + "<td>"+row[j]+"</td>";
                            if(j == cols-1){
                                htmls = htmls + "</tr>";
                            }
                        }
                    }
                    $(".table-striped").html(htmls);
                }
            });
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
</script>