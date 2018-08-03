<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;padding: 10px 20px 20px 20px;">
        <h4><?php echo $classname?>请假学生</h4>
        <table class="table table-bordered text-center" style="margin-top: 20px;">
            <tr style="background-color: #eee;">
                <td>姓名</td>
                <td>学号</td>
                <td>请假时间</td>
                <td>操作</td>
            </tr>
            <?php foreach($data as $key=>$value){ ?>
            <tr>
                <td><?=$value['stu']['name']; ?></td>
                <td><?=$value['stu']['stu_no']; ?></td>
                <td><?=$value['startTime'] ?>至<?=$value['endTime'] ?></td>
                <td>
                    <a href="###" style="color: #e75d50;" data-toggle="modal" data-target="#qjModal<?=$key; ?>">请假原因</a>
                </td>
            </tr>
                <!--请假原因-->
                <div class="modal fade" id="qjModal<?=$key; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <h4 class="modal-header">
                                请假原因
                                <button class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </h4>
                            <div class="modal-body">
                                <h5><?=$value['reason']; ?></h5>
                                <h4 class="text-right"><?=$value['name']; ?>家长</h4>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal">
                                    确定
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </table>
       

        <?php if(!empty($data)){?>
        <div style="margin-top: 20px">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
      
        </div>
        <?php } ?>
    </div>
</div>
</div>
</div>



