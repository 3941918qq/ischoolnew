<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_school_chengji".
 *
 * @property int $id
 * @property string $name chengjidan name
 * @property int $sid school id
 * @property string $ctime
 *
 * @property ZfChengji[] $zfChengjis
 * @property ZfClassChengji[] $zfClassChengjis
 * @property ZfSchool $s
 */
class ZfSchoolChengji extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_school_chengji';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'integer'],
            [['ctime'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'sid' => 'Sid',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfChengjis()
    {
        return $this->hasMany(ZfChengji::className(), ['cjdid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfClassChengjis()
    {
        return $this->hasMany(ZfClassChengji::className(), ['cjid' => 'id']);
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
    /*public static function find()
    {
        return new ZfTeacherClassQuery(get_called_class());
    }*/
}
