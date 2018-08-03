<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_order".
 *
 * @property int $id
 * @property double $total 总价格
 * @property string $inside_no 内部单号
 * @property string $trade_name 商品名，一般为“正梵幼儿园一一班王璐”
 * @property string $paytype 支付类型 微信公众号支付 微信APP支付 支付宝APP支付 手动提交订单
 * @property string $ispasspa 平安通知是否支付成功,1成功，0是默认
 * @property string $ispassjx 家校沟通是否支付成功,1成功，0是默认
 * @property string $ispassqq 亲情电话是否支付成功,1成功，0是默认
 * @property string $ispassck 餐卡支付是否支付成功,1成功，0是默认
 * @property string $ispass 是否支付成功 0默认 1成功
 * @property string $submitTime 订单提交时间
 * @property string $updateTime 订单更新时间
 * @property int $stu_id 学生ID
 * @property string $trans_id 支付宝或微信商户单号
 * @property string $type 支付种类 书费、住宿费、功能费、补卡费、学费
 * @property int $uid 用户ID
 *
 * @property ZfStudents $stu
 * @property ZfUser $u
 */
class ZfOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zf_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'stu_id', 'uid'], 'integer'],
            [['total'], 'number'],
            [['paytype', 'ispasspa', 'ispassjx', 'ispassqq', 'ispassck', 'ispass', 'type'], 'string'],
            [['submitTime', 'updateTime'], 'safe'],
            [['inside_no'], 'string', 'max' => 32],
            [['trade_name'], 'string', 'max' => 100],
            [['trans_id'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZfStudents::className(), 'targetAttribute' => ['stu_id' => 'id']],
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
            'total' => 'Total',
            'inside_no' => 'Inside No',
            'trade_name' => 'Trade Name',
            'paytype' => 'Paytype',
            'ispasspa' => 'Ispasspa',
            'ispassjx' => 'Ispassjx',
            'ispassqq' => 'Ispassqq',
            'ispassck' => 'Ispassck',
            'ispass' => 'Ispass',
            'submitTime' => 'Submit Time',
            'updateTime' => 'Update Time',
            'stu_id' => 'Stu ID',
            'trans_id' => 'Trans ID',
            'type' => 'Type',
            'uid' => 'Uid',
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
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(ZfUser::className(), ['id' => 'uid']);
    }
}
