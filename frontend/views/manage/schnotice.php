<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;  
use yii\widgets\ListView; 
?>
<div class="pull-left" style="margin-left: 10px;width: 70%;min-width: 600px;">
    <div style="background-color: white;box-shadow: 0 0 2px #ccc;">
        <div class="panel panel-body">
            <ul class="list-group">
                <li class="list-group-item clearfix">
                    <h4 class="pull-left">校内公告</h4>
                    <?= Html::a('发布', ['/manage/add-notice', 'id' => $id], ['class' => 'btn btn-success pull-right']) ?>
                </li>
                <br>
                <?=  ListView::widget([  
                    'dataProvider' => $dataProvider,  
                    'itemView' => '_notice',  
                ]); ?>
            </ul>

        </div>
    </div>
</div>
</div>
</div>

