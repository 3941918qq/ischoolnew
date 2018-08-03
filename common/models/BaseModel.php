<?php

namespace common\models;
use Yii;
use yii\base\Model;
/**
 * 公共方法基类，尽量全部用静态方法来做.
 *
 * @property integer $id
 * @property string $card_no
 * @property integer $status
 * @property integer $user_id
 * @property integer $school_id
 * @property integer $department_id
 * @property string $balance
 * @property integer $created_by
 * @property integer $created
 * @property integer $updated
 */
class BaseModel extends \yii\db\ActiveRecord
{
    public static function getClassInfo()
    {
        return ZfClass::find()->asArray()->all();
    }
    public static function getSchoolInfo()
    {
        return ZfSchool::find()->asArray()->all();
    }
    public static function getUserInfo()
    {
        return ZfUser::find()->asArray()->all();
    }
    public static function getStuInfo()
    {
        return ZfStudents::find()->asArray()->all();
    }
}
