<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zf_recharge_detail".
 *
 * @property int $id
 * @property string $card_no 消费卡序列号
 * @property string $credit 充值金额
 * @property string $type 充值的类型
 * @property string $balance 余额
 * @property string $pos_no
 * @property int $created_by
 * @property int $time 充值时间
 * @property string $note
 * @property int $is_active
 * @property string $ser_no
 * @property int $school_id
 * @property string $trade_no
 * @property int $qctime 圈存时间
 */
class ZfRechargeDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zf_recharge_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_no', 'credit', 'balance', 'pos_no', 'created_by', 'time'], 'required'],
            [['credit', 'balance'], 'number'],
            [['type'], 'string'],
            [['created_by', 'time', 'is_active', 'school_id', 'qctime'], 'integer'],
            [['card_no', 'pos_no', 'ser_no'], 'string', 'max' => 50],
            [['note', 'trade_no'], 'string', 'max' => 255],
            [['trade_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_no' => 'Card No',
            'credit' => 'Credit',
            'type' => 'Type',
            'balance' => 'Balance',
            'pos_no' => 'Pos No',
            'created_by' => 'Created By',
            'time' => 'Time',
            'note' => 'Note',
            'is_active' => 'Is Active',
            'ser_no' => 'Ser No',
            'school_id' => 'School ID',
            'trade_no' => 'Trade No',
            'qctime' => 'Qctime',
        ];
    }
}
