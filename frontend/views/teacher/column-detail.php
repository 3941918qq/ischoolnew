<?php
use yii\helpers\Html;
?>
<style>
    #tupian img{
        max-width: 100%;
    }
</style>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
<div style="background-color: white;padding: 10px 20px;box-shadow: 0 0 2px #ccc;">
    <a href="#" style="letter-spacing: -5px;">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span style="letter-spacing:5px;padding: 0 10px" onclick="history.go(-1)">返回</span>
    </a>
    <div class="page-header" style="background-color: #ccc;padding:1px">
        <h4 class="text-center"><?=Html::encode($info['title'])?></h4>
    </div>
    <p style="position: relative;z-index: 1">
        <span class="badge my_badge">简介</span>
    </p>
    <?=Html::encode($info['sketch'])?>
    <div><img style="max-width: 100%;" src="<?=Html::encode($info['columnPicture'])?>" alt="" /></div>
    <div style="padding-top: 20px">
        <p style="position: relative;z-index: 1">
            <span class="badge my_badge" style="background: dodgerblue;padding: 3px 10px">详情内容</span>
        </p>
    </div>
   <div id="tupian"> <p><?=$info['content']?></p></div>
</div>
</div>
</div>
</div>
</div>


