<?php

namespace common\models;

use Yii;
use common\models\ZfStudents;
/**
 * This is the model class for table "zf_family_number".
 *
 * @property int $id
 * @property int $stu_id 学生
 * @property string $tel 亲情号
 * @property string $releation 关系
 * @property string $created
 *
 * @property ZfStudents $stu
 */
class ZfFamilyNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_family_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_id'], 'integer'],
            [['created'], 'safe'],
            [['tel', 'relation'], 'string', 'max' => 255],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['stu_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stu_id' => '学生 ID',
            'tel' => '电话',
            'relation' => '关系',
            'created' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(ZfStudents::className(), ['id' => 'stu_id']);
    }

    /**
     * 获取当前对象所有亲情号
     */
    public function getParents($stuid){
        return self::find()->where(['stu_id'=>$stuid])->asArray()->all();
    }

    /**
     * 保存亲情号
     */
    public function saveQqtel($data){
        if($data['parent_id']>0){
            $model = self::findOne($data['parent_id']);
            if(!$model) return ['status'=>0];           
            $model -> relation = $data['parent_relation'];
            $model -> tel = $data['parent_tel'];
            $model -> created = date('Y-m-d H:i:s',time());
            if($model->save(false)) return ['status'=>1];
            else return ['status'=>0];
        }else{
            $stuModel = ZfStudents::findOne($data['stu_id']);
            if(!$stuModel) return ['status'=>0];
            $parModel = new ZfFamilyNumber();
            $parModel -> stu_id = $stuModel->id;
            // return $data['parent_relation'];
            $parModel -> relation = $data['parent_relation'];
            $parModel -> tel = $data['parent_tel'];
            $parModel -> created = date('Y-m-d H:i:s',time());
            if($parModel->save(false)) return ['status'=>1];
            else return ['status'=>0];
        }
    }

    /**
     * 删除亲情号
     */
    public function delQqtel($data){
       return  (self::findOne($data['id'])->delete())?['status'=>1]:['status'=>0];  
    }
}
