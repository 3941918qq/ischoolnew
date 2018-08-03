<?php
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;padding: 10px 20px;box-shadow: 0 0 2px #ccc;">
        <a href="#" style="letter-spacing: -5px;">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span style="letter-spacing:5px;padding: 0 10px" onclick="javascript:history.go(-1)">返回</span>
        </a>
        <hr/>
        <p class="text-primary"> <span class="badge" style="background: red;padding: 3px 10px">公告</span><span style="padding: 0 0 0 15px"><?=$noticeDetail['title']?></span> <span class="text-right pull-right"><?=$noticeDetail['submitTime']?></span></p>
        <div class="panel panel-body" style="border: 1px solid #ccc">
            <?=$noticeDetail['content']?>
        </div>
    </div>
</div>