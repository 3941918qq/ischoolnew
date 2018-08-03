<?php  
use yii\helpers\Html;  
use yii\helpers\HtmlPurifier;  
?> 
<li class="list-group-item" style="border-bottom:1px solid #ddd;">
    <a href="/teacher/notice-detail?id=<?=$model->id?>" class="text-primary"> <span class="badge" style="background: red;padding: 3px 10px">公告</span><span style="padding: 0 0 0 15px"><?= Html::encode($model->title) ?></span> <span class="text-right pull-right"><?= Html::encode($model->submitTime) ?></span></a>
</li>



