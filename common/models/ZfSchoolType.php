<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_school_type".
 *
 * @property int $id
 * @property string $name name
 *
 * @property ZfSchool[] $zfSchools
 */
class ZfSchoolType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_school_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
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
    public function getZfSchools()
    {
        return $this->hasMany(ZfSchool::className(), ['sch_type' => 'id']);
    }


}
