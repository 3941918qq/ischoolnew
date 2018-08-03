<?php

namespace common\models;

use Yii;
use common\models\ZfClass;
use common\models\ZfParentStudent;
/**
 * This is the model class for table "zf_students".
 *
 * @property int $id
 * @property string $name
 * @property string $stu_no
 * @property string $sex
 * @property int $class_id
 * @property int $school_id
 * @property string $epc_no
 * @property string $tel_no
 * @property string $enddatejx 家校沟通费用有效期
 * @property string $upendtimejx 更新enddatejx时间
 * @property string $enddateqq 亲情电话结束时间
 * @property string $upendtimeqq 亲情电话更新时间
 * @property string $enddateck 餐卡结束时间
 * @property string $upendtimeck 餐卡更新时间
 * @property string $enddatepa 平安通知有效期
 * @property string $upendtimepa 更新平安通知时间
 *
 * @property ZfChengji[] $zfChengjis
 * @property ZfFamilyNumber[] $zfFamilyNumbers
 * @property ZfOrder[] $zfOrders
 * @property ZfParentStudent[] $zfParentStudents
 * @property ZfSafeCard[] $zfSafeCards
 * @property ZfStudentLeave[] $zfStudentLeaves
 * @property ZfClass $class
 * @property ZfSchool $school
 * @property ZfUser[] $zfUsers
 */
class ZfStudents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_students';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id', 'school_id'], 'integer'],
            [['enddatejx', 'upendtimejx', 'enddateqq', 'upendtimeqq', 'enddateck', 'upendtimeck', 'enddatepa', 'upendtimepa'], 'safe'],
            [['name', 'stu_no'], 'string', 'max' => 255],
            [['sex'], 'string', 'max' => 5],
            [['epc_no', 'tel_no'], 'string', 'max' => 50],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['school_id' => 'id']],
            [['stu_no','tel_no','epc_no'], 'unique'],
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
            'stu_no' => 'Stu No',
            'sex' => 'Sex',
            'class_id' => 'Class ID',
            'school_id' => 'School ID',
            'epc_no' => 'Epc No',
            'tel_no' => 'Tel No',
            'enddatejx' => 'Enddatejx',
            'upendtimejx' => 'Upendtimejx',
            'enddateqq' => 'Enddateqq',
            'upendtimeqq' => 'Upendtimeqq',
            'enddateck' => 'Enddateck',
            'upendtimeck' => 'Upendtimeck',
            'enddatepa' => 'Enddatepa',
            'upendtimepa' => 'Upendtimepa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfChengjis()
    {
        return $this->hasMany(ZfChengji::className(), ['stuid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfFamilyNumbers()
    {
        return $this->hasMany(ZfFamilyNumber::className(), ['stu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfOrders()
    {
        return $this->hasMany(ZfOrder::className(), ['stu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfParentStudents()
    {
        return $this->hasMany(ZfParentStudent::className(), ['stu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSafeCards()
    {
        return $this->hasMany(ZfSafeCard::className(), ['stuid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfStudentLeaves()
    {
        return $this->hasMany(ZfStudentLeave::className(), ['stu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(ZfClass::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(ZfSchool::className(), ['id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfUsers()
    {
        return $this->hasMany(ZfUser::className(), ['last_stuid' => 'id']);
    }
    /**
     * @return checkbind
     */
    public  function getCheckBind($id){
       return (ZfParentStudent::findOne(['stu_id'=>$id]))?1:0;      
    }
    // public function beforeSave($insert){
    //     if(parent::beforeSave($insert)){

    //     }else{
    //         return false;
    //     }
    // }
    
}
