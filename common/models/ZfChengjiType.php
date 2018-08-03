<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_chengji_type".
 *
 * @property int $id
 * @property string $name kaoshi type
 * @property int $sort 用于排序
 */
class ZfChengjiType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_chengji_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
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
            'sort' => 'Sort',
        ];
    }

    /**
     * @inheritdoc
     * @return ZfAccessTokenQuery the active query used by this AR class.
     */
/*    public static function find()
    {
        return new ZfAccessTokenQuery(get_called_class());
    }*/
}
