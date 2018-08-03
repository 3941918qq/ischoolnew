<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_complaint_proposal".
 *
 * @property int $id 投诉建议表
 * @property string $title 标题
 * @property string $content 内容
 * @property int $sid 学校ID
 * @property string $submitTime 提交时间
 * @property string $attachment 附件地址
 * @property int $uid 用户ID
 *
 * @property ZfUser $u
 * @property ZfSchool $s
 */
class ZfComplaintProposal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_complaint_proposal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content'], 'required'],
            [['id', 'sid', 'uid'], 'integer'],
            [['content'], 'string'],
            [['submitTime'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['attachment'], 'string', 'max' => 200],
            [['id'], 'unique'],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['uid' => 'id']],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['sid' => 'id']],
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
            'sid' => 'Sid',
            'submitTime' => 'Submit Time',
            'attachment' => 'Attachment',
            'uid' => 'Uid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'uid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'sid']);
    }
}
