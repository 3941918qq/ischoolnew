<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_subject".
 *
 * @property int $id
 * @property string $name
 * @property int $sort 排序
 *
 * @property ZfChengji[] $zfChengjis
 */
class ZfSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
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
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfChengjis()
    {
        return $this->hasMany(ZfChengji::className(), ['kmid' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ZfTeacherClassQuery the active query used by this AR class.
     */
/*    public static function find()
    {
        return new ZfTeacherClassQuery(get_called_class());
    }*/
}
