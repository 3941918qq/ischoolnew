<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_card_info".
 *
 * @property int $id
 * @property string $card_no 卡号
 * @property string $user_no 学号
 * @property string $user_name
 * @property int $department_id
 * @property string $status 卡的状态
 * @property int $school_id
 * @property string $balance 余额
 * @property int $created_by 创建人
 * @property int $created
 * @property int $updated 更新日期
 * @property string $deposit 押金
 * @property string $type 卡的类型
 * @property int $role_id 角色ID
 * @property string $phyid
 */
class ZfCardInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zf_card_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_no', 'user_name', 'department_id', 'school_id', 'balance', 'created_by', 'created', 'updated'], 'required'],
            [['department_id', 'school_id', 'created_by', 'created', 'updated', 'role_id'], 'integer'],
            [['status', 'type'], 'string'],
            [['balance', 'deposit'], 'number'],
            [['card_no', 'user_no', 'user_name'], 'string', 'max' => 50],
            [['phyid'], 'string', 'max' => 200],
            [['card_no', 'school_id'], 'unique', 'targetAttribute' => ['card_no', 'school_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_no' => 'Card No',
            'user_no' => 'User No',
            'user_name' => 'User Name',
            'department_id' => 'Department ID',
            'status' => 'Status',
            'school_id' => 'School ID',
            'balance' => 'Balance',
            'created_by' => 'Created By',
            'created' => 'Created',
            'updated' => 'Updated',
            'deposit' => 'Deposit',
            'type' => 'Type',
            'role_id' => 'Role ID',
            'phyid' => 'Phyid',
        ];
    }
}
