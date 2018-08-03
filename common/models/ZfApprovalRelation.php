<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_approval_relation".
 *
 * @property int $id 工作计划审核流程关系表
 * @property string $name 姓名
 * @property int $work_id 工作计划ID对应flow表中的ID
 * @property string $oktime 审批时间
 * @property int $uid 审批人ID对应user表用户ID
 * @property int $next_uid 下一位审批人 当为0时代表当前为最后一位
 * @property int $xuhao 序号
 * @property int $status 状态 0审核中 1同意  2拒绝  3没轮到我审批
 * @property int $is_deleted 0代表正常 1代表已撤销
 * @property string $reason 拒绝或同意的理由
 * @property int $tjr_uid 提交人ID
 *
 * @property ZfApprovalFlow $work
 * @property ZfUser $u
 * @property ZfUser $nextU
 * @property ZfUser $tjrU
 */
class ZfApprovalRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_approval_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_id', 'uid', 'next_uid', 'xuhao', 'status', 'is_deleted', 'tjr_uid'], 'integer'],
            [['oktime'], 'safe'],
            [['name', 'reason'], 'string', 'max' => 255],
            [['work_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfApprovalFlow::className(), 'targetAttribute' => ['work_id' => 'id']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['uid' => 'id']],
            [['next_uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['next_uid' => 'id']],
            [['tjr_uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['tjr_uid' => 'id']],
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
            'work_id' => 'Work ID',
            'oktime' => 'Oktime',
            'uid' => 'Uid',
            'next_uid' => 'Next Uid',
            'xuhao' => 'Xuhao',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'reason' => 'Reason',
            'tjr_uid' => 'Tjr Uid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWork()
    {
        return $this->hasOne(ZfApprovalFlow::className(), ['id' => 'work_id']);
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
    public function getNextU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'next_uid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTjrU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'tjr_uid']);
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
