<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_chengji".
 *
 * @property string $id 成绩表，存放学生各科成绩
 * @property int $stuid 学生id
 * @property string $stuname 学生名
 * @property int $cid 班级id
 * @property int $cjdid 成绩单id
 * @property int $kmid 科目id
 * @property string $kmname 科目名称
 * @property double $score 科目成绩
 * @property int $ctime
 *
 * @property ZfStudents $stu
 * @property ZfClass $c
 * @property ZfSchoolChengji $cjd
 * @property ZfSubject $km
 */
class ZfChengji extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_chengji';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stuid', 'cid', 'cjdid', 'kmid', 'ctime'], 'integer'],
            [['score'], 'number'],
            [['stuname', 'kmname'], 'string', 'max' => 10],
            [['stuid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['stuid' => 'id']],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfClass::className(), 'targetAttribute' => ['cid' => 'id']],
            [['cjdid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchoolChengji::className(), 'targetAttribute' => ['cjdid' => 'id']],
            [['kmid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSubject::className(), 'targetAttribute' => ['kmid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stuid' => 'Stuid',
            'stuname' => 'Stuname',
            'cid' => 'Cid',
            'cjdid' => 'Cjdid',
            'kmid' => 'Kmid',
            'kmname' => 'Kmname',
            'score' => 'Score',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(ZfStudents::className(), ['id' => 'stuid']);
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
    public function getCjd()
    {
        return $this->hasOne(ZfSchoolChengji::className(), ['id' => 'cjdid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKm()
    {
        return $this->hasOne(ZfSubject::className(), ['id' => 'kmid']);
    }

    /**
     * @inheritdoc
     * @return ZfAccessTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZfAccessTokenQuery(get_called_class());
    }
}
