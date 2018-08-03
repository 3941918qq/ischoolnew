<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_news".
 *
 * @property int $id 学校新闻动态
 * @property int $sid 学校ID
 * @property string $title 标题
 * @property string $content 内容
 * @property string $submitTime 提交时间
 * @property int $uid 用户ID
 *
 * @property ZfSchool $s
 * @property ZfUser $u
 */
class ZfNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sid', 'uid'], 'integer'],
            [['content'], 'string'],
            [['submitTime'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['sid' => 'id']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'title' => 'Title',
            'content' => 'Content',
            'submitTime' => 'Submit Time',
            'uid' => 'Uid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'uid']);
    }
}
