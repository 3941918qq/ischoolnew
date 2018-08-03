<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_im_message".
 *
 * @property int $id
 * @property string $content 内容
 * @property string $converType 会话类型
 * @property string $sendId 发送人id
 * @property string $targetId 目标人id
 * @property string $sendtime 发送时间
 * @property string $url
 * @property string $messageType 消息类型
 * @property int $messageDirection 信息导向1是己方客服，2用户
 */
class ZfImMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zf_im_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['messageDirection'], 'integer'],
            [['converType', 'sendtime', 'messageType'], 'string', 'max' => 20],
            [['sendId', 'targetId', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'converType' => 'Conver Type',
            'sendId' => 'Send ID',
            'targetId' => 'Target ID',
            'sendtime' => 'Sendtime',
            'url' => 'Url',
            'messageType' => 'Message Type',
            'messageDirection' => 'Message Direction',
        ];
    }
}
