<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_parent_student".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $stu_id
 * @property string $created
 * @property int $sid sid
 *
 * @property ZfUser $parent
 * @property ZfStudents $stu
 * @property ZfSchool $s
 */
class ZfParentStudent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_parent_student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'stu_id', 'sid'], 'integer'],
            [['created'], 'safe'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['stu_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'stu_id' => 'Stu ID',
            'created' => 'Created',
            'sid' => 'Sid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(ZfStudents::className(), ['id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'sid']);
    }

    /**
     * 获取班级
     */
    static function getClass($stuid){
        $result= ZfStudents::find()->select('zf_class.name,zf_class.id')
        ->join('inner join','zf_parent_student','zf_parent_student.stu_id =zf_students.id ')
        ->join('inner join','zf_class','zf_class.id =zf_students.class_id ')
        ->where(['zf_parent_student.stu_id'=>$stuid])
        ->asArray()
        ->one();
        return $result;
    }
}
