<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_role_privilege".
 *
 * @property int $id
 * @property int $role_id 角色id
 * @property string $alias 权限别名唯一
 * @property string $type 类型
 * @property string $controller 控制器名
 * @property string $action 方法名
 *  @property string $group 分组
 *
 * @property ZfRole $role
 */
class ZfRolePrivilege extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zf_role_privilege';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id'], 'integer'],
            [['alias', 'type', 'controller', 'action', 'group'], 'string', 'max' => 50],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfRole::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'alias' => 'Alias',
            'type' => 'Type',
            'controller' => 'Controller',
            'action' => 'Action',
            'group' => 'Group', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(ZfRole::className(), ['id' => 'role_id']);
    }
}
