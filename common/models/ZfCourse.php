<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_course".
 *
 * @property int $id
 * @property string $name
 *
 * @property ZfTeacherClass[] $zfTeacherClasses
 */
class ZfCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfTeacherClasses()
    {
        return $this->hasMany(ZfTeacherClass::className(), ['course_id' => 'id']);
    }
}
