<?php  
use yii\helpers\Html;  
use yii\helpers\HtmlPurifier;  
use common\models\ZfNotice;
?> 
<li class="list-group-item" style="border-bottom:1px solid #ddd;">
    <a href="/manage/notice-detail?id=<?=$model->id?>" class="text-primary"> <span class="badge" style="background: red;padding: 3px 10px">公告</span>
        <span style="padding: 0 0 0 15px">
            <?php
                $cache=\yii::$app->cache;
                $data = $cache->get('notice-title');
                $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT title FROM zf_notice']);
                if ($data === false) {
                    // $data 在缓存中没有找到，则重新计算它的值
                    $data=ZfNotice::findOne($model->id);
                    // 将 $data 存放到缓存供下次使用
                    $cache->set($key, $data['title'],3600,$dependency);
                }
                echo Html::encode($model->title);
            ?>

        </span>
        
        <span class="text-right pull-right"><?= Html::encode($model->submitTime) ?></span></a>
</li>



