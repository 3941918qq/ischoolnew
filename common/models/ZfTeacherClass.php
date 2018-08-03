<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_teacher_class".
 *
 * @property int $id
 * @property int $t_id
 * @property int $c_id 如果为校长或其他不授课的管理层，则为0，普通老师为班级ID
 * @property int $role_id
 * @property int $course_id 课程ID，例如语文数学英文
 * @property int $level 年级
 * @property int $sid sid
 * @property string $ispass 标志位，0未审核，1已通过，2拒绝
 * @property string $created
 *
 * @property ZfUser $t
 * @property ZfClass $c
 * @property ZfRole $role
 * @property ZfCourse $course
 * @property ZfSchool $s
 */
class ZfTeacherClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_teacher_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 't_id', 'c_id', 'role_id', 'course_id', 'level', 'sid'], 'integer'],
            [['ispass'], 'string'],
            [['created'], 'safe'],
            [['t_id', 'c_id', 'role_id'], 'unique', 'targetAttribute' => ['t_id', 'c_id', 'role_id']],
            [['id'], 'unique'],
            [['t_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['t_id' => 'id']],
            [['c_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfClass::className(), 'targetAttribute' => ['c_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfRole::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfCourse::className(), 'targetAttribute' => ['course_id' => 'id']],
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
            't_id' => 'T ID',
            'c_id' => 'C ID',
            'role_id' => 'Role ID',
            'course_id' => 'Course ID',
            'level' => 'Level',
            'sid' => 'Sid',
            'ispass' => 'Ispass',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 't_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(ZfClass::className(), ['id' => 'c_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(ZfRole::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(ZfCourse::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'sid']);
    }
    
}
