<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_role".
 *
 * @property int $id
 * @property string $name role name
 *
 * @property ZfTeacherClass[] $zfTeacherClasses
 */
class ZfRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_role';
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
    public function getZfTeacherClasses()
    {
        return $this->hasMany(ZfTeacherClass::className(), ['role_id' => 'id']);
    }
}
