<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_class".
 *
 * @property int $id
 * @property string $name 学校名字
 * @property int $level 年级
 * @property int $class 班级号 选择班级下拉时候排序用
 * @property int $sid 学校
 * @property string $created
 *
 * @property ZfApprovalFlow[] $zfApprovalFlows
 * @property ZfAttachment[] $zfAttachments
 * @property ZfChengji[] $zfChengjis
 * @property ZfSchool $s
 * @property ZfClassChengji[] $zfClassChengjis
 * @property ZfStudents[] $zfStudents
 * @property ZfTeacherClass[] $zfTeacherClasses
 */
class ZfClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'class', 'sid'], 'integer'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'level' => 'Level',
            'class' => 'Class',
            'sid' => 'Sid',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalFlows()
    {
        return $this->hasMany(ZfApprovalFlow::className(), ['cid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfAttachments()
    {
        return $this->hasMany(ZfAttachment::className(), ['grade_id' => 'level']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfChengjis()
    {
        return $this->hasMany(ZfChengji::className(), ['cid' => 'id']);
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
    public function getZfClassChengjis()
    {
        return $this->hasMany(ZfClassChengji::className(), ['cid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfStudents()
    {
        return $this->hasMany(ZfStudents::className(), ['class_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfTeacherClasses()
    {
        $bzrid=$this->Bzrid();
        return $this->hasMany(ZfTeacherClass::className(), ['c_id' => 'id'])->onCondition(['role_id' => $bzrid]);
    }
    /**
     * 
     * @param type $insert
     * 获取班主任id
     */
    public function Bzrid(){
       $one= ZfRole::findOne(['name'=>'班主任']);
       return $one->id;
    }
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->created=date('Y-m-d H:i:s',time());
            return true;
        }else
            return false;
        
    }
     /**
     * 获取该班的班主任
     */
    public function getT($id){
         $class=self::findOne($id);
         $teaclass=$class->zfTeacherClasses;
         if($teaclass){
             foreach($teaclass as $info){
                 $user=ZfUser::find()->where(['id'=>$info->attributes['t_id']])->one();   
                 return $user->name;
             }
         }else return null;
    }
    public function getLevel(){
        return [
            '1'=>"一年级",
            '2'=>"二年级",
            '3'=>"三年级",
            '4'=> "四年级",
            '5'=>"五年级",
            '6'=>"六年级",
            '7'=>"七年级",
            '8'=>"八年级",
            '9'=>"九年级"
        ];
    }
    public function getClassnumber(){
        return array(
            '1'=>'一',
            '2'=>'二',
            '3'=>'三',
            '4'=>'四',
            '5'=>'五',
            '6'=>'六',
            '7'=>'七',
            '8'=>'八',
            '9'=>'九',
            '10'=>'十',
            '11'=>'十一',
            '12'=>'十二',
            '13'=>'十三',
            '14'=>'十四',
            '15'=>'十五',
            '16'=>'十六',
            '17'=>'十七',
            '18'=>'十八',
            '19'=>'十九',
            '20'=>'二十',
            '21'=>'二十一',
            '22'=>'二十二',
            '23'=>'二十三',
            '24'=>'二十四',
            '25'=>'二十五',
            '26'=>'二十六',
            '27'=>'二十七',
            '28'=>'二十八',
            '29'=>'二十九',
            '30'=>'三十',
            '31'=>'三十一',
            '32'=>'三十二',
            '33'=>'三十三',
            '34'=>'三十四',
            '35'=>'三十五',
            '36'=>'三十六',
            '37'=>'三十七',
            '38'=>'三十八',
            '39'=>'三十九',
            '40'=>'四十'
        );
    }
    
}
