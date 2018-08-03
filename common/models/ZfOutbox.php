<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_outbox".
 *
 * @property int $id 发件箱
 * @property string $title 发件箱标题
 * @property string $content 发件箱内容
 * @property string $submitTime 提交时间
 * @property string $attachment ti
 * @property string $type 消息类型，0家校通消息，1校内交流消息(也包括教育局消息)
 * @property int $out_uid 发件人用户ID
 *
 * @property ZfUser $outU
 */
class ZfOutbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_outbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'out_uid'], 'integer'],
            [['content', 'type'], 'string'],
            [['submitTime'], 'safe'],
            [['title'], 'string', 'max' => 20],
            [['attachment'], 'string', 'max' => 200],
            [['id'], 'unique'],
            [['out_uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['out_uid' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'out_uid']);
    }
}
