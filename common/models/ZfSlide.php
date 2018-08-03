<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_slide".
 *
 * @property int $id 学校首页幻灯片
 * @property int $sid 学校ID
 * @property string $picurl 图片路径
 *
 * @property ZfSchool $s
 */
class ZfSlide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_slide';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sid'], 'integer'],
            [['picurl'], 'string', 'max' => 100],
            [['id'], 'unique'],
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
            'picurl' => 'Picurl',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'sid']);
    }

}
