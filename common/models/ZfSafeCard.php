<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_safe_card".
 *
 * @property string $id
 * @property int $stuid student id
 * @property string $info 进校或出校
 * @property int $ctime 进离校时间
 * @property int $yearmonth 当前的年份月份
 * @property int $yearweek 当前的年份和当年中的第几个星期
 * @property int $weekday
 * @property int $receivetime 服务器收到epc时间
 *
 * @property ZfStudents $stu
 */
class ZfSafeCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_safe_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stuid', 'info', 'ctime'], 'required'],
            [['stuid', 'ctime', 'yearmonth', 'yearweek', 'weekday', 'receivetime'], 'integer'],
            [['info'], 'string', 'max' => 100],
            [['stuid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['stuid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stuid' => '学生ID',
            'info' => '类型',
            'ctime' => '刷卡时间',
            'yearmonth' => 'Yearmonth',
            'yearweek' => 'Yearweek',
            'weekday' => 'Weekday',
            'receivetime' => '接收时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(ZfStudents::className(), ['id' => 'stuid']);
    }
    
    public function stuidGetClass($stuid){
        $stu=ZfStudents::find()->with('class')->where(['id'=>$stuid])->asArray()->one();
        return $stu['class']['name'];
    }
}
