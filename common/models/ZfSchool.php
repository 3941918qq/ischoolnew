<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_school".
 *
 * @property int $id
 * @property string $name 学校名
 * @property int $pro_id 省ID
 * @property int $city_id 城市ID
 * @property int $county_id 区ID
 * @property int $sch_type 学校类型
 * @property string $setting 设置
 * @property string $created
 * @property string $ispass 标志位，0未开通，1已开通
 * @property string $ckpass 餐卡标志位，0未开通，1已开通
 * @property string $skpass 水卡标志位，0未开通，1已开通
 * @property string $papass 平安通知标志位，0未开通，1已开通
 * @property string $jxpass 家校沟通标志位，0未开通，1已开通
 * @property string $qqpass 亲情电话标志位，0未开通，1已开通
 * @property string $xfpass 学费标志位，0未开通，1已开通
 * @property string $month_total 月价钱
 * @property string $half_total 半年价钱
 * @property string $year_total 年价钱
 * @property string $is_youhui 是否优惠，0无优惠，1有优惠
 *
 * @property ZfApprovalFlow[] $zfApprovalFlows
 * @property ZfAttachment[] $zfAttachments
 * @property ZfClass[] $zfClasses
 * @property ZfClassImages[] $zfClassImages
 * @property ZfClassImages[] $zfClassImages0
 * @property ZfColumn[] $zfColumns
 * @property ZfComplaintProposal[] $zfComplaintProposals
 * @property ZfNews[] $zfNews
 * @property ZfNotice[] $zfNotices
 * @property ZfParentStudent[] $zfParentStudents
 * @property ZfProvince $pro
 * @property ZfCity $city
 * @property ZfCounty $county
 * @property ZfSchoolType $schType
 * @property ZfSchoolChengji[] $zfSchoolChengjis
 * @property ZfSchoolPicture[] $zfSchoolPictures
 * @property ZfSlide[] $zfSlides
 * @property ZfStudents[] $zfStudents
 * @property ZfTeacherClass[] $zfTeacherClasses
 * @property ZfUser[] $zfUsers
 */
class ZfSchool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id', 'city_id', 'county_id', 'sch_type'], 'integer'],
            [['created'], 'safe'],
            [['ispass', 'ckpass', 'skpass', 'papass', 'jxpass', 'qqpass', 'xfpass', 'is_youhui'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['setting', 'month_total', 'half_total', 'year_total'], 'string', 'max' => 500],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfProvince::className(), 'targetAttribute' => ['pro_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfCity::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['county_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfCounty::className(), 'targetAttribute' => ['county_id' => 'id']],
            [['sch_type'], 'exist', 'skipOnError' => true, 'targetClass' => ZfSchoolType::className(), 'targetAttribute' => ['sch_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'pro_id' => '省份 ID',
            'city_id' => '城市 ID',
            'county_id' => '县区 ID',
            'sch_type' => '学校类型',
            'setting' => '设置',
            'created' => '创建时间',
            'ispass' => 'Ispass',
            'ckpass' => 'Ckpass',
            'skpass' => 'Skpass',
            'papass' => 'Papass',
            'jxpass' => 'Jxpass',
            'qqpass' => 'Qqpass',
            'xfpass' => 'Xfpass',
            'month_total' => 'Month Total',
            'half_total' => 'Half Total',
            'year_total' => 'Year Total',
            'is_youhui' => 'Is Youhui',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfApprovalFlows()
    {
        return $this->hasMany(ZfApprovalFlow::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfAttachments()
    {
        return $this->hasMany(ZfAttachment::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfClasses()
    {
        return $this->hasMany(ZfClass::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfClassImages()
    {
        return $this->hasMany(ZfClassImages::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfClassImages0()
    {
        return $this->hasMany(ZfClassImages::className(), ['cid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfColumns()
    {
        return $this->hasMany(ZfColumn::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfComplaintProposals()
    {
        return $this->hasMany(ZfComplaintProposal::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfNews()
    {
        return $this->hasMany(ZfNews::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfNotices()
    {
        return $this->hasMany(ZfNotice::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfParentStudents()
    {
        return $this->hasMany(ZfParentStudent::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(ZfProvince::className(), ['id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(ZfCity::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounty()
    {
        return $this->hasOne(ZfCounty::className(), ['id' => 'county_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchType()
    {
        return $this->hasOne(ZfSchoolType::className(), ['id' => 'sch_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSchoolChengjis()
    {
        return $this->hasMany(ZfSchoolChengji::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSchoolPictures()
    {
        return $this->hasMany(ZfSchoolPicture::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfSlides()
    {
        return $this->hasMany(ZfSlide::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfStudents()
    {
        return $this->hasMany(ZfStudents::className(), ['school_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfTeacherClasses()
    {
        return $this->hasMany(ZfTeacherClass::className(), ['sid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZfUsers()
    {
        return $this->hasMany(ZfUser::className(), ['last_sid' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ZfTeacherClassQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new ZfTeacherClassQuery(get_called_class());
    // }
}
