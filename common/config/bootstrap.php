<?php
//require_once __DIR__."/../../cron/base.config.php";
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@mobile', dirname(dirname(__DIR__)) . '/mobile');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
