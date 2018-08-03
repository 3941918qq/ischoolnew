<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_province".
 *
 * @property int $id
 * @property string $name
 *
 * @property ZfCity[] $zfCities
 * @property ZfSchool[] $zfSchools
 */
class ZfProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_province';
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
    public function getZfCities()
    {
        return $this->hasMany(ZfCity::className(), ['pro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSchools()
    {
        return $this->hasMany(ZfSchool::className(), ['pro_id' => 'id']);
    }
}
