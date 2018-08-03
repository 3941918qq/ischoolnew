<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_class_images".
 *
 * @property int $id
 * @property int $sid school id
 * @property int $cid class id
 * @property string $picurl picture url
 *
 * @property ZfSchool $s
 * @property ZfSchool $c
 */
class ZfClassImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_class_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'cid'], 'integer'],
            [['picurl'], 'string', 'max' => 255],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['sid' => 'id']],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['cid' => 'id']],
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
            'cid' => 'Cid',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'cid']);
    }
}
