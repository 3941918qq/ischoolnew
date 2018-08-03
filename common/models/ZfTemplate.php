<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_template".
 *
 * @property int $id 客服消息模板消息id
 * @property string $name 模版名
 * @property string $time 更新时间
 * @property int $num 使用次数
 * @property string $temid 模版ID
 */
class ZfTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'num'], 'integer'],
            [['time'], 'safe'],
            [['name'], 'string', 'max' => 10],
            [['temid'], 'string', 'max' => 100],
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
            'time' => 'Time',
            'num' => 'Num',
            'temid' => 'Temid',
        ];
    }

    /**
     * @inheritdoc
     * @return ZfUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZfUserQuery(get_called_class());
    }
}
