<?php

namespace common\models;

use Yii;
use common\models\ZfStudents;
/**
 * This is the model class for table "zf_student_leave".
 *
 * @property string $id
 * @property int $stu_id student id
 * @property string $startTime begin time
 * @property string $endTime end time
 * @property string $ctime create time
 * @property int $flag 标志位,0未通过审批，1有效，2待审批，3已拒绝显示
 * @property string $reason reason
 * @property string $passTime pass time
 * @property int $passUid pass user id
 * @property int $uid shenqingren user id
 *
 * @property ZfStudents $stu
 * @property ZfUser $u
 */
class ZfStudentLeave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_student_leave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_id', 'flag', 'passUid', 'uid'], 'integer'],
            [['startTime', 'endTime', 'ctime', 'passTime'], 'safe'],
            [['reason'], 'string', 'max' => 255],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['stu_id' => 'id']],
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
            'stu_id' => 'Stu ID',
            'startTime' => 'Start Time',
            'endTime' => 'End Time',
            'ctime' => 'Ctime',
            'flag' => 'Flag',
            'reason' => 'Reason',
            'passTime' => 'Pass Time',
            'passUid' => 'Pass Uid',
            'uid' => 'Uid',
        ];
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
    public function getU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'uid']);
    }

    public function getClass($stuid){
        $res=ZfStudents::find()->with('class')->where(['zf_students.id'=>$stuid])->asArray()->one();
        return $res['class']['name'];
    }
}
