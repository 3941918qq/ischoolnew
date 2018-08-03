<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_approval_flow".
 *
 * @property int $id 审批流内容表
 * @property string $name 提交人姓名
 * @property string $oldtitle 提交文档原始标题
 * @property int $cid 班级ID
 * @property string $submitTime 提交时间
 * @property string $oktime 审批时间
 * @property string $status 老师状态0待审核 1已审核 2已拒绝
 * @property string $attachment 上传附件URL地址
 * @property string $title 标题
 * @property string $content 计划描述
 * @property int $uid 用户ID
 * @property int $sid 学校ID
 * @property int $is_deleted 0代表正常 1代表已撤销
 *
 * @property ZfClass $c
 * @property ZfUser $u
 * @property ZfSchool $s
 * @property ZfApprovalRelation[] $zfApprovalRelations
 */
class ZfApprovalFlow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_approval_flow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'uid', 'sid', 'is_deleted'], 'integer'],
            [['submitTime', 'oktime'], 'safe'],
            [['status', 'content'], 'string'],
            [['name'], 'string', 'max' => 20],
            [['oldtitle', 'title'], 'string', 'max' => 50],
            [['attachment'], 'string', 'max' => 200],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfClass::className(), 'targetAttribute' => ['cid' => 'id']],
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
            'name' => 'Name',
            'oldtitle' => 'Oldtitle',
            'cid' => 'Cid',
            'submitTime' => 'Submit Time',
            'oktime' => 'Oktime',
            'status' => 'Status',
            'attachment' => 'Attachment',
            'title' => 'Title',
            'content' => 'Content',
            'uid' => 'Uid',
            'sid' => 'Sid',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(ZfClass::className(), ['id' => 'cid']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalRelations()
    {
        return $this->hasMany(ZfApprovalRelation::className(), ['work_id' => 'id']);
    }
}
