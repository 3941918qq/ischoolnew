<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_user".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $tel 电话
 * @property string $password 密码
 * @property string $role_type 角色
 * @property int $is_pass 是否通过
 * @property string $openid
 * @property string $pushid
 * @property string $uuid
 * @property int $last_sid
 * @property int $last_stuid
 * @property int $last_cid
 * @property string $last_login_time
 * @property string $register_time
 * @property string $updated
 *
 * @property ZfApprovalFlow[] $zfApprovalFlows
 * @property ZfApprovalRelation[] $zfApprovalRelations
 * @property ZfApprovalRelation[] $zfApprovalRelations0
 * @property ZfApprovalRelation[] $zfApprovalRelations1
 * @property ZfAttachment[] $zfAttachments
 * @property ZfClassChengji[] $zfClassChengjis
 * @property ZfColumn[] $zfColumns
 * @property ZfComplaintProposal[] $zfComplaintProposals
 * @property ZfInbox[] $zfInboxes
 * @property ZfInbox[] $zfInboxes0
 * @property ZfNews[] $zfNews
 * @property ZfNotice[] $zfNotices
 * @property ZfOrder[] $zfOrders
 * @property ZfOutbox[] $zfOutboxes
 * @property ZfParentStudent[] $zfParentStudents
 * @property ZfStudentLeave[] $zfStudentLeaves
 * @property ZfTeacherClass[] $zfTeacherClasses
 * @property ZfSchool $lastS
 * @property ZfStudents $lastStu
 */
class ZfUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_type'], 'string'],
            [['last_sid', 'last_stuid','last_cid'], 'integer'],
            [['last_login_time', 'register_time', 'updated'], 'safe'],
            [['name', 'password', 'openid', 'pushid', 'uuid'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 20],
            [['is_pass'], 'integer', 'max' => 2],
            [['tel'], 'unique'],
            [['last_sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['last_sid' => 'id']],
            [['last_stuid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['last_stuid' => 'id']],
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
            'tel' => 'Tel',
            'password' => 'Password',
            'role_type' => 'Role Type',
            'is_pass' => 'Is Pass',
            'openid' => 'Openid',
            'pushid' => 'Pushid',
            'uuid' => 'Uuid',
            'last_sid' => 'Last Sid',
            'last_stuid' => 'Last Stuid',
            'last_cid' => 'Last Cid',
            'last_login_time' => 'Last Login Time',
            'register_time' => 'Register Time',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalFlows()
    {
        return $this->hasMany(ZfApprovalFlow::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalRelations()
    {
        return $this->hasMany(ZfApprovalRelation::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalRelations0()
    {
        return $this->hasMany(ZfApprovalRelation::className(), ['next_uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalRelations1()
    {
        return $this->hasMany(ZfApprovalRelation::className(), ['tjr_uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfAttachments()
    {
        return $this->hasMany(ZfAttachment::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfClassChengjis()
    {
        return $this->hasMany(ZfClassChengji::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfColumns()
    {
        return $this->hasMany(ZfColumn::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfComplaintProposals()
    {
        return $this->hasMany(ZfComplaintProposal::className(), ['uid' => 'id']);
    }

     /**
    * @return \yii\db\ActiveQuery
    */
    public function getZfSuggests() 
    { 
       return $this->hasMany(ZfSuggest::className(), ['uid' => 'id']); 
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfInboxes()
    {
        return $this->hasMany(ZfInbox::className(), ['out_uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfInboxes0()
    {
        return $this->hasMany(ZfInbox::className(), ['in_uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfNews()
    {
        return $this->hasMany(ZfNews::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfNotices()
    {
        return $this->hasMany(ZfNotice::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfOrders()
    {
        return $this->hasMany(ZfOrder::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfOutboxes()
    {
        return $this->hasMany(ZfOutbox::className(), ['out_uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfParentStudents()
    {
        return $this->hasMany(ZfParentStudent::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfStudentLeaves()
    {
        return $this->hasMany(ZfStudentLeave::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfTeacherClasses()
    {
        return $this->hasMany(ZfTeacherClass::className(), ['t_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'last_sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastStu()
    {
        return $this->hasOne(ZfStudents::className(), ['id' => 'last_stuid']);
    }
}
