<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_county".
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 *
 * @property ZfCity $city
 * @property ZfSchool[] $zfSchools
 */
class ZfCounty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_county';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfCity::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'city_id' => 'City ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(ZfCity::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSchools()
    {
        return $this->hasMany(ZfSchool::className(), ['county_id' => 'id']);
    }
}
