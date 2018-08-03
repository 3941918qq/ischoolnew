<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_inbox".
 *
 * @property int $id 收件箱
 * @property string $title 收件箱标题
 * @property string $content 收件箱内容
 * @property string $submitTime 提交时间
 * @property string $attachment 附件
 * @property string $type 消息类型，0家校通消息，1校内交流消息(也包括教育局消息)
 * @property int $out_uid 发送人用户ID
 * @property int $in_uid 收件人用户ID
 *
 * @property ZfUser $outU
 * @property ZfUser $inU
 */
class ZfInbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_inbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'out_uid', 'in_uid'], 'integer'],
            [['content', 'type'], 'string'],
            [['submitTime'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['attachment'], 'string', 'max' => 200],
            [['id'], 'unique'],
            [['out_uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['out_uid' => 'id']],
            [['in_uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['in_uid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'submitTime' => 'Submit Time',
            'attachment' => 'Attachment',
            'type' => 'Type',
            'out_uid' => 'Out Uid',
            'in_uid' => 'In Uid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'out_uid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'in_uid']);
    }
}
