<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_group_message".
 *
 * @property int $id 后台群组推送信息
 * @property int $user_id 后台登录系统账号ID
 * @property string $paramers 参数
 * @property string $send_role 发送对象 家长或教师
 * @property string $title 标题
 * @property string $content 内容
 * @property string $submitTime 提交时间
 * @property int $in_uid 收件人id
 */
class ZfGroupMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_group_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'paramers', 'send_role', 'title', 'content', 'submitTime', 'in_uid'], 'required'],
            [['user_id', 'in_uid'], 'integer'],
            [['send_role', 'content'], 'string'],
            [['submitTime'], 'safe'],
            [['paramers'], 'string', 'max' => 500],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'paramers' => 'Paramers',
            'send_role' => 'Send Role',
            'title' => 'Title',
            'content' => 'Content',
            'submitTime' => 'Submit Time',
            'in_uid' => 'In Uid',
        ];
    }
}
