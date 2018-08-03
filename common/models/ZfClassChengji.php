<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_class_chengji".
 *
 * @property int $id
 * @property int $cid class id
 * @property int $cjid chengji id
 * @property string $isopen 是否班级内公开，0不公开，1公开
 * @property int $uid creater uid
 * @property string $ctime create time
 *
 * @property ZfClass $c
 * @property ZfSchoolChengji $cj
 * @property ZfUser $u
 */
class ZfClassChengji extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_class_chengji';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'cjid', 'uid'], 'integer'],
            [['isopen'], 'string'],
            [['ctime'], 'safe'],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfClass::className(), 'targetAttribute' => ['cid' => 'id']],
            [['cjid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchoolChengji::className(), 'targetAttribute' => ['cjid' => 'id']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfUser::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'cjid' => 'Cjid',
            'isopen' => 'Isopen',
            'uid' => 'Uid',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(ZfClass::className(), ['id' => 'cid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCj()
    {
        return $this->hasOne(ZfSchoolChengji::className(), ['id' => 'cjid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'uid']);
    }
}
