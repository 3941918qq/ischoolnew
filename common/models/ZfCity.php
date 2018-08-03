<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_city".
 *
 * @property int $id
 * @property string $name
 * @property int $pro_id
 * @property string $created
 *
 * @property ZfProvince $pro
 * @property ZfSchool[] $zfSchools
 */
class ZfCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id'], 'integer'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfProvince::className(), 'targetAttribute' => ['pro_id' => 'id']],
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
            'pro_id' => 'Pro ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(ZfProvince::className(), ['id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSchools()
    {
        return $this->hasMany(ZfSchool::className(), ['city_id' => 'id']);
    }
}
