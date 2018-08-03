<?php
use yii\helpers\Html;
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;padding: 10px 20px;box-shadow: 0 0 2px #ccc;">
        <div class="clearfix">
            <h4 class="pull-left">学校微官网</h4>
        </div>
        <div style="background-color: #eee;padding: 10px; font-size: 18px;" class="text-center"><?= Html::encode($school['name']) ?></div>
        <div class="slide">
            <?php if(!empty($slide)){?>
            <?php foreach($slide as $v){?>
            <img  src="<?= '/'.$v['picurl']?>"/>
            <?php }}else{ ?> <img  src="/img/gw_1.jpg" /><?php }?>
        </div>
    </div>
    <ul class="list-group" style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
        <li style="border: none;line-height: 30px;" class="list-group-item">
            <span class="gg">公告</span><?= !empty($notice)? Html::encode($notice['title']):"暂无公告信息！";?><?php if(!empty($notice)){ echo Html::a('>>查看详情', ['/teacher/notice-detail', 'id' => $notice['id']], ['class' => 'pull-right']);}?>
        </li>
        <li style="border: none;border-top: 1px solid #ddd;line-height: 30px;" class="list-group-item">
            <span style="background-color: #FF9900;" class="gg">动态</span><?= !empty($news)?Html::encode($news['title']):"暂无动态信息！";?><?php if(!empty($notice)){ echo Html::a('>>查看详情', ['/teacher/news-detail', 'id' => $news['id']], ['class' => 'pull-right']);}?>
        </li>
    </ul>
    <?php  if(count($column) !=0) {?>
    <div style="background-color: white;padding: 10px 20px;margin-top: 5px;box-shadow: 0 0 2px #ccc;">
       <?php foreach($column as $key=>$value){?>
        <div class="zhanshi">
            <div class="xgk clearfix">
                <span class="gg"><?=!empty($value['columnName'])?Html::encode($value['columnName']):"暂无名称"?></span>
            </div>
            <div>
                    <img class="pull-left" style="max-width: 400px;" src="<?=!empty($value['columnPicture'])? Html::encode($value['columnPicture']):'/img/zhengfan.png'?>" />
                    <div class="pull-left" style="margin-top: 10px;">
                        <h5 style="color: #FF8484;"><?=!empty($value['title'])?Html::encode($value['title']):"标题暂时为空"?></h5>
                        <p><?=!empty($value['sketch'])?Html::encode($value['sketch']):"简介暂时为空"?></p>
                    </div>
                <?php if(!empty($value['title'])){ echo Html::a('>>查看详情', ['/manage/column-detail', 'id' => $value['id']], ['class' => 'xgk_xq']);}?>
 
            </div>
        </div>
        <?php } ?>
    </div><?php }?>
</div>
</div>
</div>


