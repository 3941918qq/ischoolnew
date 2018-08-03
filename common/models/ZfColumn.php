<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_column".
 *
 * @property int $id 首页栏目
 * @property string $columnName 栏目名称
 * @property string $title 内容标题
 * @property string $sketch 简介
 * @property string $content 内容
 * @property string $columnPicture 栏目图片
 * @property int $sid 学校ID
 * @property int $uid 用户ID
 * @property string $submitTime 提交时间
 *
 * @property ZfSchool $s
 * @property ZfUser $u
 */
class ZfColumn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_column';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sid', 'uid'], 'integer'],
            [['content'], 'string'],
            [['submitTime'], 'safe'],
            [['columnName'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 50],
            [['sketch'], 'string', 'max' => 200],
            [['columnPicture'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchool::className(), 'targetAttribute' => ['sid' => 'id']],
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
            'columnName' => 'Column Name',
            'title' => 'Title',
            'sketch' => 'Sketch',
            'content' => 'Content',
            'columnPicture' => 'Column Picture',
            'sid' => 'Sid',
            'uid' => 'Uid',
            'submitTime' => 'Submit Time',
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
    public function getU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'uid']);
    }
    
    /**
     * add添加栏目名称
     */
    public function addColumn($name,$sid,$uid){
        $models=new self;
        $models->columnName=$name;
        $models->sid=$sid;
        $models->uid=$uid;
        $models->submitTime=date('Y-m-d H:i:s',time());
        return  ($models->save(false)) ? true : false;
    }
}
