<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_attachment".
 *
 * @property int $id 教师上传资料表
 * @property string $submitTime 提交时间
 * @property int $sid 学校ID
 * @property string $updateTime 更新时间
 * @property string $title 附件名
 * @property string $attachment 文档路径
 * @property int $grade_id 年级ID
 * @property string $type 分组名称标识（班主任，年级主任，群组）
 * @property int $uid 上传者用户ID
 *
 * @property ZfSchool $s
 * @property ZfUser $u
 * @property ZfClass $grade
 */
class ZfAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sid', 'grade_id', 'uid'], 'integer'],
            [['submitTime', 'updateTime'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['attachment'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 22],
            [['id'], 'unique'],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['sid' => 'id']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['uid' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfClass::className(), 'targetAttribute' => ['grade_id' => 'level']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'submitTime' => 'Submit Time',
            'sid' => 'Sid',
            'updateTime' => 'Update Time',
            'title' => 'Title',
            'attachment' => 'Attachment',
            'grade_id' => 'Grade ID',
            'type' => 'Type',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(ZfClass::className(), ['level' => 'grade_id']);
    }

    /**
     * @inheritdoc
     * @return ZfAccessTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZfAccessTokenQuery(get_called_class());
    }
}
