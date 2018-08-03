<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_school_picture".
 *
 * @property int $id
 * @property int $sid school id
 * @property string $pic_url picture url
 *
 * @property ZfSchool $s
 */
class ZfSchoolPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_school_picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'integer'],
            [['pic_url'], 'string', 'max' => 255],
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
            'sid' => 'Sid',
            'pic_url' => 'Pic Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'sid']);
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
