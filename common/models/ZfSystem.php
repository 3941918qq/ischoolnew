<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_system".
 *
 * @property int $id
 * @property string $type
 * @property string $setting
 */
class ZfSystem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string', 'max' => 255],
            [['setting'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'setting' => 'Setting',
        ];
    }

    /**
     * @inheritdoc
     * @return ZfTeacherClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZfTeacherClassQuery(get_called_class());
    }
}
