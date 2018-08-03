<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_suggest".
 *
 * @property int $id 投诉建议表
 * @property string $title 标题
 * @property string $content 内容
 * @property int $sid 学校ID
 * @property string $submitTime 提交时间
 * @property string $attachment 附件地址
 * @property int $uid 用户ID
 * @property string $note 备注 
 * @property ZfUser $u
 * @property ZfSchool $s
 */
class ZfSuggest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zf_suggest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content'], 'required'],
            [['id', 'sid', 'uid'], 'integer'],
            [['content', 'note'], 'string'],
            [['submitTime'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['attachment'], 'string', 'max' => 200],
            [['id'], 'unique'],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['uid' => 'id']],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['sid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'sid' => '学校ID',
            'submitTime' => '提交时间',
            'attachment' => '附件',
            'uid' => '用户ID',
            'note' => '备注',
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
